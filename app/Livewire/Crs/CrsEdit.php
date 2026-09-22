<?php

namespace App\Livewire\Crs;

use App\Livewire\Crs\Concerns\WithBookingForm;
use App\Models\CRS\Lists;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CrsEdit extends Component
{
    use LivewireAlert;
    use WithBookingForm;

    #[Locked]
    public $dataId;

    protected $listeners = ['store'];

    public function mount($id)
    {
        $list = Lists::findOrFail($id);
        abort_unless($this->canManage($list), 403);

        $this->dataId = $list->id;
        $this->name = $list->name;
        $this->car_id = $list->car_id;
        $this->driver_id = $list->driver_id;
        $this->user_id = $list->user_id;
        $this->passenger = $list->passenger ?? [];
        $this->travel = $list->travel;
        $this->start_date = $list->start_date?->format('Y-m-d');
        $this->start_time = $list->start_time?->format('H:i');
        $this->end_date = $list->end_date?->format('Y-m-d');
        $this->end_time = $list->end_time?->format('H:i');
        $this->description = $list->description;

        $this->loadOptions();
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
            ]
        );
    }

    public function store()
    {
        $this->validate();
        $list = Lists::findOrFail($this->dataId);
        abort_unless($this->canManage($list), 403);

        $list->update($this->bookingData());

        return $this->flash('warning', 'แก้ไขรายการเรียบร้อย !', [
            'timer' => 10000,
            'toast' => true,
        ], route('crs-lists'));
    }

    public function render()
    {
        return view('livewire.crs.crs-edit');
    }
}
