<?php

namespace App\Livewire\Ntfy;

use App\Models\NTFY\Ntfy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Phattarachai\LineNotify\Line;


class NtfyLists extends Component
{
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
        Toaster::error('ลบเรียบร้อย !');
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
