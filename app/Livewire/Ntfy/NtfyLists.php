<?php

namespace App\Livewire\Ntfy;

use App\Models\NTFY\Ntfy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
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

    public function line($id)
    {
        $ntfy = Ntfy::findOrFail($id);

        //$ntfy = Ntfy::whereTime('published_at', '=', Carbon::now()->format('H:i'))->actived()->first();

        // dd($ntfy);
        // dd($ntfy->whereTime('published_at', '=', Carbon::now()->format('H:m'))->first());

        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
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
