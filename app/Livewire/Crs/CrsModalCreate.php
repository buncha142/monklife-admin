<?php

namespace App\Livewire\Crs;

use App\Models\CRS\Lists;
use Carbon\Carbon;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CrsModalCreate extends ModalComponent
{
    public $lists;
    public $date;
    public $start_time;
    public $end_time;


    public static function modalMaxWidth(): string
    {
        return '2xl';
    }


    public function render()
    {
        return view('livewire.crs.crs-modal-create');
    }

    public function mount($start_date, $start_time, $end_time)
    {
        $this->lists  = Lists::whereDate('start_date', $start_date)->orderBy('start_time', 'asc')->get();
        $this->date = Carbon::createFromFormat('Y-m-d', $start_date);
        $this->start_time = $start_time;
        $this->end_time = $end_time;
    }


}
