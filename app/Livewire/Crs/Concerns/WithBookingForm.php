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
            'description' => 'required',
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
