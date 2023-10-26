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
        $ntfy = Ntfy::whereTime('published_at', '=', Carbon::now()->format('H:i'))->actived()->first();
        if ($ntfy) {
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
        return Command::SUCCESS;
    }
}
