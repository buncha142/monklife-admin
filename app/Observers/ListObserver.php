<?php

namespace App\Observers;

use App\Models\CRS\Lists;
use Carbon\Carbon;
use Phattarachai\LineNotify\Line;

class ListObserver
{
    /**
     * Handle the Lists "created" event.
     */
    public function created(Lists $lists): void
    {
        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
        $bookcar = $lists;
        $end_date = $bookcar->end_date ?  Carbon::parse($bookcar->end_date)->thaidate('D j M y') : '';
        $passenger = $bookcar->passenger ? implode(",", $bookcar->passenger) : '-';
        $description = $bookcar->description ? 'รายละเอียดเพิ่มเติม : '.$bookcar->description : '';
        $line->send('
+ เพิ่มรายการจองรถ +
ภารกิจ: '.$bookcar->name.'
รถ: '.$bookcar->car->name.'
คนขับ: '.$bookcar->driver->user->nickname.'
วันเดินทาง: '.Carbon::parse($bookcar->start_date)->thaidate('D j M y').' เวลา:'.Carbon::parse($bookcar->start_time)->format('H:i').' น.
กลับ: '.$end_date.' เวลา:'.Carbon::parse($bookcar->end_time)->format('H:i').' น.
ผู้จอง: '.$bookcar->user->nickname.'
ผู้โดยสาร: '.$passenger.'
'.$description.'');
    }

    /**
     * Handle the Lists "updated" event.
     */
    public function updated(Lists $lists): void
    {
        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
        $bookcar = $lists;
        $end_date = $bookcar->end_date ?  Carbon::parse($bookcar->end_date)->thaidate('D j M y') : '';
        $passenger = $bookcar->passenger ? implode(",", $bookcar->passenger) : '-';
        $description = $bookcar->description ? 'รายละเอียดเพิ่มเติม : '.$bookcar->description : '';
        $line->send('
! แก้ไขรายการจองรถ !
ภารกิจ: '.$bookcar->name.'
รถ: '.$bookcar->car->name.'
คนขับ: '.$bookcar->driver->user->nickname.'
วันเดินทาง: '.Carbon::parse($bookcar->start_date)->thaidate('D j M y').' เวลา:'.Carbon::parse($bookcar->start_time)->format('H:i').' น.
กลับ: '.$end_date.' เวลา:'.Carbon::parse($bookcar->end_time)->format('H:i').' น.
ผู้จอง: '.$bookcar->user->nickname.'
ผู้โดยสาร: '.$passenger.'
'.$description.'');
    }

    /**
     * Handle the Lists "deleted" event.
     */
    public function deleted(Lists $lists): void
    {
        $line = new Line('lA78gCjQa6wv24JuWBGl603IFt1AhDcM7MDMHIDuIsp');
        $bookcar = $lists;
        $end_date = $bookcar->end_date ?  Carbon::parse($bookcar->end_date)->thaidate('D j M y') : '';
        $passenger = $bookcar->passenger ? implode(",", $bookcar->passenger) : '-';
        $description = $bookcar->description ? 'รายละเอียดเพิ่มเติม : '.$bookcar->description : '';
        $line->send('
- ยกเลิกรายการจองรถ -
ภารกิจ: '.$bookcar->name.'
รถ: '.$bookcar->car->name.'
คนขับ: '.$bookcar->driver->user->nickname.'
วันเดินทาง: '.Carbon::parse($bookcar->start_date)->thaidate('D j M y').' เวลา:'.Carbon::parse($bookcar->start_time)->format('H:i').' น.
กลับ: '.$end_date.' เวลา:'.Carbon::parse($bookcar->end_time)->format('H:i').' น.
ผู้จอง: '.$bookcar->user->nickname.'
ผู้โดยสาร: '.$passenger.'
'.$description.'');
    }

    /**
     * Handle the Lists "restored" event.
     */
    public function restored(Lists $lists): void
    {
        //
    }

    /**
     * Handle the Lists "force deleted" event.
     */
    public function forceDeleted(Lists $lists): void
    {
        //
    }
}
