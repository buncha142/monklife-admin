<?php

namespace App\Livewire\Ntfy;

use App\Models\NTFY\Ntfy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Phattarachai\LineNotify\Line;


class NtfyLists extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view(
            'livewire.ntfy.ntfy-lists',
            [
                'ntfies' => Ntfy::published()->get(),
            ]
        );
    }

    public function delete($id)
    {
        Ntfy::findOrFail($id)->delete();
        $this->alert('error', 'ลบรายการเรียบร้อย !',[
            'timer' => 3000,
            'closeButton' => true,
           ]);
    }

    public function line($id)
    {
        $ntfy = Ntfy::findOrFail($id);
        $line = new Line('5y5hRLWkK3qqd4iKgkU1fODQXStIUySXoaiSlFdAyek');
        $body = $ntfy->body ? '
'.$ntfy->body : '';
        $passenger = $ntfy->passenger ? '
ผู้รับบุญ: '.implode(",", $ntfy->passenger) : '';
        if (!empty($ntfy->image)) {
            $line = $line->imageUrl(url(Storage::url($ntfy->image)));
        }
$line->send(' '.$ntfy->title.$body.$passenger);
    }
}
