<?php

namespace App\Livewire\Ntfy;

use App\Models\NTFY\Ntfy;
use Carbon\Carbon;
use Livewire\Component;
use Phattarachai\LineNotify\Line;


class NtfyLists extends Component
{
    public function render()
    {
        return view('livewire.ntfy.ntfy-lists',
        [
            'ntfies' => Ntfy::published()->get(),
        ]);
    }

    public function line($id)
    {
        // dd(Carbon::now()->format('Y-m-d H:i'));
        $ntfy = Ntfy::findOrFail($id);
        dd($ntfy->published_at->format('Y-m-d H:i'));
        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
        $body = $ntfy->body ? $ntfy->body  : '';
        $passenger = $ntfy->passenger ? 'ผู้รับบุญ: '.implode(",", $ntfy->passenger) : '';
        if ($ntfy->image) {
            $line = $line->imageUrl(url($ntfy->image));
        }
        if (!$body&&!$passenger) {
        $line->send('
'.$ntfy->title);
        }else if (!$body) {
        $line->send('
'.$ntfy->title.'
ผู้รับบุญ: '.implode(",", $ntfy->passenger));
        }else if (!$passenger) {
        $line->send('
'.$ntfy->title.'

'.$ntfy->body);
        }else{
        $line->send('
'.$ntfy->title.'

'.$ntfy->body.'

ผู้รับบุญ: '.implode(",", $ntfy->passenger));
        }
    }

}
