<?php

namespace App\Livewire\Crs;

use App\Models;
use App\Models\CRS\Lists;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

use function Livewire\store;

class CrsCreate extends Component
{
    public $cars;
    public $dirvers;
    public $users = [];
    public $passenger = [];

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

    public $car_id;
    public $driver_id;
    public $user_id;
    public $description;
    public $travel = 0;

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

    public function mount()
    {
        $this->cars = Models\CRS\Car::actived()->get();
        $this->dirvers = Models\CRS\Driver::actived()->get();
        $this->users = Models\User::actived()->orderBy('doo', 'asc')->get();
        $this->user_id = Auth::user()->id;
        $this->car_id = Models\CRS\Car::actived()->pluck('id')->first();
        $this->driver_id = Models\CRS\Driver::actived()->pluck('id')->first();
    }


    public function save()
    {
        $this->validate();
        $checks = Lists::whereDate('start_date', '=', $this->start_date)->get();
        if (count($checks)!=0) {
            $this->dispatch(
                "openModal",
                component: "crs.crs-modal-create",
                arguments: [
                    'start_date' => $this->start_date,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]);

        } else {
            $this->store();
        }
    }

    public function store()
    {
         Lists::create($this->all());
         Toaster::success('เพิ่มรายการเรียบร้อย !');
         return redirect()->route('crs-lists');
         $this->reset();
    }


    public function render()
    {
        return view('livewire.crs.crs-create');
    }
}
