<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\NTFY\Ntfy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Phattarachai\LineNotify\Line;

class NtfySend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ntfy-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->format('Y-m-d');
        $time = Carbon::now()->format('H:i');
        $ntfys = Ntfy::whereDate('published_at', '=', $date)->whereTime('published_at', '=', $time)->actived()->get();
        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');

        if (count($ntfys) != 0) {
            foreach ($ntfys as $ntfy) {
                $body = $ntfy->body ? '
    ' . $ntfy->body : '';
                $passenger = $ntfy->passenger ? '
    ผู้รับบุญ: ' . implode(",", $ntfy->passenger) : '';
                if (!empty($ntfy->image)) {
                    $lineSend = $line->imageUrl(url(Storage::url($ntfy->image)));
                }
                $lineSend->send(' ' . $ntfy->title . $body . $passenger);
            }
        }
        return Command::SUCCESS;
    }
}
