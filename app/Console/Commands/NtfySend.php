<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\NTFY\Ntfy;
use Illuminate\Console\Command;
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
        $ntfy = Ntfy::where('published_at', '=', Carbon::now()->format('Y-m-d H:i'))->actived()->first();

        if ($ntfy) {
            $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
            $body = $ntfy->body ? $ntfy->body  : '';
            $passenger = $ntfy->passenger ? 'ผู้รับบุญ: ' . implode(",", $ntfy->passenger) : '';
            if ($ntfy->image) {
                $line = $line->imageUrl(url($ntfy->image));
            }
            if (!$body && !$passenger) {
                $line->send('
' . $ntfy->title);
            } else if (!$body) {
                $line->send('
' . $ntfy->title . '
ผู้รับบุญ: ' . implode(",", $ntfy->passenger));
            } else if (!$passenger) {
                $line->send('
' . $ntfy->title . '

' . $ntfy->body);
            } else {
                $line->send('
' . $ntfy->title . '

' . $ntfy->body . '

ผู้รับบุญ: ' . implode(",", $ntfy->passenger));
            }
        }

        return Command::SUCCESS;
    }
}
