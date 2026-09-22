<?php

namespace App\Livewire\Crs\Concerns;

use App\Models;
use App\Models\CRS\Lists;
use Illuminate\Support\Facades\Auth;

/**
 * ฟิลด์ / validation / ตัวเลือก ที่ใช้ร่วมกันระหว่าง CrsCreate และ CrsEdit
 */
trait WithBookingForm
{
    public $cars;
    public $dirvers;
    public $users = [];

    public $name;
    public $car_id;
    public $driver_id;
    public $user_id;
    public $passenger = [];
    public $travel = 0;
    public $start_date;
    public $start_time;
    public $end_date;
    public $end_time;
    public $description;

    protected function rules()
    {
        $overnight = $this->travel == 1;

        return [
            'name' => 'required|max:255',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'required|exists:drivers,id',
            'user_id' => 'required|exists:users,id',
            'passenger' => 'array',
            'start_date' => 'required|date|after:yesterday',
            'start_time' => 'required',
            // ค้างคืน: ต้องมีวันกลับ และเวลากลับไม่จำเป็นต้องหลังเวลาไป (คนละวัน)
            'end_date' => $overnight ? 'required|date|after:start_date' : 'nullable',
            'end_time' => $overnight ? 'required' : 'required|after:start_time',
            'description' => 'nullable',
        ];
    }

    protected function messages()
    {
        return [
            'required' =>'กรุณาป้อนข้อมูล',
            'name.max' => 'ข้อมูลยาวเกินไป',
            'car_id.exists' => 'ไม่พบรถที่เลือก',
            'driver_id.exists' => 'ไม่พบคนขับที่เลือก',
            'user_id.exists' => 'ไม่พบผู้จองที่เลือก',
            'start_date.date' => 'กรุณาป้อนข้อมูลเป็นรูปแบบวันที่',
            'start_date.after' => 'เลือกเฉพาะวันนี้เป็นต้นไป กรุณาเลือกใหม่',
            'end_date.date' => 'กรุณาป้อนข้อมูลเป็นรูปแบบวันที่',
            'end_date.after' => 'วันกลับต้องหลังวันเดินทาง กรุณาเลือกใหม่',
            'end_time.after' => 'ป้อนเวลาหลังจากเวลาออกเดินทาง กรุณาป้อนเวลาใหม่',
        ];
    }

    protected function loadOptions(): void
    {
        $this->cars = Models\CRS\Car::actived()->get();
        $this->dirvers = Models\CRS\Driver::actived()->with('user')->get();
        $this->users = Models\User::actived()->orderBy('doo', 'asc')->get();
    }

    protected function isAdmin(): bool
    {
        return Auth::user()->hasRole('Admin');
    }

    protected function canManage(Lists $list): bool
    {
        return $list->user_id == Auth::id() || $this->isAdmin();
    }

    // ไป-กลับ → ล้างวันกลับที่ซ่อนอยู่ ไม่ให้ค้างไปบันทึก
    public function updatedTravel($value)
    {
        if ($value == 0) {
            $this->end_date = null;
            $this->resetValidation('end_date');
        }
    }

    // เปลี่ยนผู้จอง (Admin) → แทนชื่อผู้จองเดิมในผู้โดยสารด้วยผู้จองใหม่
    public function updatingUserId($value)
    {
        $old = $this->users->firstWhere('id', $this->user_id)?->nickname;
        $new = $this->users->firstWhere('id', $value)?->nickname;

        $this->passenger = array_values(array_unique(array_filter([
            ...array_diff($this->passenger, [$old]),
            $new,
        ])));
    }

    // ปุ่มลัดเวลาเดินทาง
    public function startPresets(): array
    {
        return ['06:00', '07:00', '08:00', '09:00', '13:00'];
    }

    // ปุ่มลัดเวลากลับ: ไป-กลับ = ระยะเวลาจากเวลาไป (นาที => ป้ายปุ่ม), ค้างคืน = เวลาคงที่
    public function durationPresets(): array
    {
        return [60 => '+1 ชม.', 120 => '+2 ชม.', 180 => '+3 ชม.', 240 => '+4 ชม.'];
    }

    public function endPresets(): array
    {
        return ['09:00', '12:00', '15:00', '17:00'];
    }

    // ตัวเลือกเวลาทุก 30 นาที (04:00–22:00) + ค่าปัจจุบันที่ไม่ตรงช่วง (เช่นข้อมูลเก่า 08:15)
    public function timeSlots(): array
    {
        $slots = [];
        for ($m = 4 * 60; $m <= 22 * 60; $m += 30) {
            $slots[] = $this->minutesToTime($m);
        }

        $slots = array_unique(array_filter([...$slots, $this->start_time, $this->end_time]));
        sort($slots);

        return $slots;
    }

    // ไป-กลับ: กดปุ่ม +N ชม. → เวลากลับ = เวลาไป + N
    public function setDuration(int $minutes)
    {
        if (! $this->start_time) {
            return;
        }

        $this->end_time = $this->minutesToTime(min($this->timeToMinutes($this->start_time) + $minutes, 23 * 60 + 30));
        $this->resetValidation('end_time');
    }

    // ไป-กลับ: เปลี่ยนเวลาไป → เลื่อนเวลากลับตาม โดยคงระยะเวลาเดิม
    public function updatingStartTime($value)
    {
        if ($this->travel != 0 || ! $value || ! $this->start_time || ! $this->end_time) {
            return;
        }

        $duration = $this->timeToMinutes($this->end_time) - $this->timeToMinutes($this->start_time);

        if ($duration > 0) {
            $this->end_time = $this->minutesToTime(min($this->timeToMinutes($value) + $duration, 23 * 60 + 30));
        }
    }

    protected function timeToMinutes(string $time): int
    {
        [$h, $m] = array_map('intval', explode(':', $time));

        return $h * 60 + $m;
    }

    protected function minutesToTime(int $minutes): string
    {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    protected function bookingData(): array
    {
        $data = $this->only((new Lists)->getFillable());

        // สมาชิกทั่วไปจองในนามตัวเองเท่านั้น (กันการแก้ user_id ผ่าน devtools)
        if (! $this->isAdmin()) {
            $data['user_id'] = Auth::id();
        }

        if ($this->travel == 0) {
            $data['end_date'] = null;
        }

        return $data;
    }
}
