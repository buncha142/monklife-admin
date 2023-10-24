<?php

namespace App\Livewire\Crs;
use Carbon\Carbon;
use App\Models\CRS\Lists;
use LivewireUI\Modal\ModalComponent;

class CrsModalEdit extends ModalComponent
{
    public $name;
    public $date;
    public $start_time;
    public $end_time;

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }
    public function mount($name, $start_date, $start_time, $end_time)
    {
        $this->name = $name;
        $this->date = Carbon::createFromFormat('Y-m-d', $start_date);
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }
    public function render()
    {
        return view('livewire.crs.crs-modal-edit');
    }
}
