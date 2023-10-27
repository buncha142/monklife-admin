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

        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $ntfys = Ntfy::whereDate('published_at', '=', $date)->whereTime('published_at', '=', $time)->actived()->get();

        //dd(count($ntfys));
        if (count($ntfys) != 0) {
            foreach ($ntfys as $ntfy) {
                $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
                $body = $ntfy->body ? '
' . $ntfy->body : '';
                $passenger = $ntfy->passenger ? '
ผู้รับบุญ: ' . implode(",", $ntfy->passenger) : '';
                if (!empty($ntfy->image)) {
                    $line = $line->imageUrl(url(Storage::url($ntfy->image)));
                }
                $line->send(' ' . $ntfy->title . $body . $passenger);
            }
        }



        // $ntfy = Ntfy::findOrFail($id);
//         $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
//         $body = $ntfy->body ? '
// '.$ntfy->body : '';
//         $passenger = $ntfy->passenger ? '
// ผู้รับบุญ: '.implode(",", $ntfy->passenger) : '';
//         if (!empty($ntfy->image)) {
//             $line = $line->imageUrl(url(Storage::url($ntfy->image)));
//         }
// $line->send(' '.$ntfy->title.$body.$passenger);
    }
}
