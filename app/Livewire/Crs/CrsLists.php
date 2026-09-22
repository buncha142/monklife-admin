<?php

namespace App\Livewire\Crs;

use App\Models\CRS\Lists;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CrsLists extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.crs.crs-lists', [
            'bookcars' => Lists::with(['car', 'driver.user', 'user'])
                ->whereDate('start_date', '>=', today())
                ->orderBy('start_date')
                ->orderBy('start_time')
                ->get(),
        ]);
    }

    public function delete($id)
    {
        $list = Lists::findOrFail($id);
        abort_unless($list->user_id == Auth::id() || Auth::user()->hasRole('Admin'), 403);

        $list->delete();
        $this->alert('error', 'ลบรายการเรียบร้อย !', [
            'timer' => 3000,
            'closeButton' => true,
        ]);
    }
}
