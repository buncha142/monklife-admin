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
