<?php

namespace App\Livewire\Crs;

use App\Models\CRS\Lists;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CrsLists extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.crs.crs-lists',
        [
            'bookcars' => Lists::whereDate('start_date', '>=', Carbon::today()->toDateString())->orderBy('start_date', 'ASC')->orderBy('start_time', 'ASC')->get(),
        ]);
    }

    public function delete($id)
        {
            Lists::findOrFail($id)->delete();
            $this->alert('error', 'ลบรายการเรียบร้อย !',[
                'timer' => 3000,
                'closeButton' => true,
               ]);

        }
}
