<?php

namespace App\Livewire\Crs;

use App\Livewire\Crs\Concerns\WithBookingForm;
use App\Models\CRS\Lists;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CrsCreate extends Component
{
    use LivewireAlert;
    use WithBookingForm;

    protected $listeners = ['store'];

    public function mount()
    {
        $this->loadOptions();
        $this->user_id = Auth::id();
        $this->car_id = $this->cars->first()?->id;
        $this->driver_id = $this->dirvers->first()?->id;
        $this->start_date = today()->format('Y-m-d');
        $this->passenger = array_filter([Auth::user()->nickname]);
    }

    public function save()
    {
        $this->validate();

        if (Lists::whereDate('start_date', $this->start_date)->exists()) {
            $this->dispatch(
                "openModal",
                component: "crs.crs-modal-create",
                arguments: [
                    'start_date' => $this->start_date,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                ]
            );
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();
        Lists::create($this->bookingData());
        return $this->flash('success', 'เพิ่มรายการเรียบร้อย !', [
            'timer' => 10000,
            'toast' => true,
        ], route('crs-lists'));
    }

    public function render()
    {
        return view('livewire.crs.crs-create');
    }
}
