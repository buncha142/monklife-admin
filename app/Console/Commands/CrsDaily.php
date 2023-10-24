<?php

namespace App\Console\Commands;

use App\Models\CRS\Lists;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Phattarachai\LineNotify\Line;

class CrsDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crs-daily';

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
        $today = Carbon::today()->format('Y-m-d');
        $lists = Lists::where('start_date', '=', $today)->orderBy('start_time', 'asc')->get();
        $line = new Line('wobn88LKGB9vVcI8AxDmQiIRi3uT1qEOUAhRidAk3gH');

        if (count($lists) != 0) {
            $i = 0;
            $line->send(
                '
วันนี้ วัน' . Carbon::today()->thaidate('l') . ' ที่' . Carbon::today()->thaidate('j M y') . '
มีการจองรถ ' . Lists::where('start_date', '=', $today)->count() . ' รายการ'
            );

            foreach ($lists as $list) {
                $i++;
                $end_date = $list->end_date ?  Carbon::parse($list->end_date)->thaidate('j M y') : '';
                $passenger = $list->passenger ? implode(",", $list->passenger) : '-';
                $description = $list->description ? 'รายละเอียดเพิ่มเติม : ' . $list->description : '';
                $line->send('
รายการที่ ' . $i . '
ภารกิจ: ' . $list->name . '
รถ: ' . $list->car->name . '
คนขับ: ' . $list->driver->user->nickname . '
วันเดินทางเวลา:' . Carbon::parse($list->start_time)->format('H:i') . ' น.
กลับ: ' . $end_date . ' เวลา:' . Carbon::parse($list->end_time)->format('H:i') . ' น.
ผู้จอง: ' . $list->user->nickname . '
ผู้โดยสาร: ' . $passenger . '
' . $description . '');
            }
        }


        return Command::SUCCESS;
    }
}
