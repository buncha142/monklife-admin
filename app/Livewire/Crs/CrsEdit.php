<?php

namespace App\Livewire\Crs;

use App\Models\CRS\Lists;
use App\Models;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CrsEdit extends Component
{
    use LivewireAlert;

    public $cars;
    public $dirvers;
    public $users;
    public $passenger = [];
    public $car_id;
    public $driver_id;
    public $user_id;
    public $description;
    public $travel;
    public $dataId;

    #[Rule('required|max:255')]
    public $name;

    #[Rule('required|date|after:yesterday')]
    public $start_date;

    #[Rule('required')]
    public $start_time;

    #[Rule('nullable|date|after:start_date')]
    public $end_date;

    #[Rule('required|after:start_time')]
    public $end_time;


    protected $listeners = ['store'];

    protected $messages = [
        'name.required' => 'กรุณาป้อนข้อมูล',
        'name.max:255' => 'กรุณาป้อนข้อมูลมากเกินไป',
        'start_date.required' => 'กรุณาป้อนข้อมูล',
        'start_date.date' => 'กรุณาป้อนข้อมูลเป็นรูปแบบวันที่',
        'start_date.after' => 'เลือกเฉพาะวันนี้เป็นต้นไป กรุณาเลือกใหม่',
        'start_time.required' => 'กรุณาป้อนข้อมูล',
        'end_date.date' => 'กรุณาป้อนข้อมูลเป็นรูปแบบวันที่',
        'end_date.after' => 'เลือกเฉพาะวันนี้เป็นต้นไป กรุณาเลือกใหม่',
        'end_time.required' => 'กรุณาป้อนข้อมูล',
        'end_time.after' => 'ป้อนเวลาหลังจากเวลาออกเดินทาง กรุณาป้อนเวลาใหม่',
    ];

    public function mount($id)
    {
        $bookcars = Lists::findOrFail($id);
        $this->name = $bookcars->name;
        $this->car_id = $bookcars->car_id;
        $this->driver_id = $bookcars->driver_id;
        $this->user_id = $bookcars->user_id;
        $this->start_date = $bookcars->start_date ? Carbon::parse($bookcars->start_date )->format('Y-m-d') : '';
        $this->start_time = $bookcars->start_time ? Carbon::parse($bookcars->start_time )->format('H:i') : '';
        $this->end_date = $bookcars->end_date ? Carbon::parse($bookcars->end_date )->format('Y-m-d') : Null;
        $this->end_time = $bookcars->end_time ? Carbon::parse($bookcars->end_time )->format('H:i') : '';
        $this->description = $bookcars->description;
        $this->passenger = $bookcars->passenger ? $bookcars->passenger : [];
        $this->dataId = $id;
        $this->travel = $bookcars->travel;

        $this->cars = Models\CRS\Car::actived()->get();
        $this->dirvers = Models\CRS\Driver::actived()->get();
        $this->users = Models\User::actived()->orderBy('doo', 'asc')->get();

    }

    public function save()
    {
        $this->validate();
        $this->dispatch(
            "openModal",
            component: "crs.crs-modal-edit",
            arguments: [
                'name' => $this->name,
                'start_date' => $this->start_date,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);
    }

    public function store()
    {
         Lists::find($this->dataId)->update($this->all());
         $this->reset();
         $this->alert('warning', 'แก้ไขรายการเรียบร้อย !',[
            'timer' => 10000,
            'toast' => true,
           ]);
         return redirect()->route('crs-lists');
    }

    public function render()
    {
        return view('livewire.crs.crs-edit');
    }
}
