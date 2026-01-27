<?php

namespace App\Observers;

use App\Models\Enrollment;
use App\Models\Keuzedeel;
use App\Models\Waitlist;

class KeuzedelObserver
{
    /**
     * Handle the Keuzedeel "deleting" event.
     * Automatically cancel all enrollments and clear waitlist when a keuzedeel is deleted.
     */
    public function deleting(Keuzedeel $keuzedeel): void
    {
        // Cancel all enrollments for this keuzedeel
        Enrollment::where('keuzedeel_id', $keuzedeel->id)
            ->where('status', '!=', 'cancelled')
            ->update(['status' => 'cancelled']);

        // Cancel all waitlist entries for this keuzedeel
        Waitlist::where('keuzedeel_id', $keuzedeel->id)
            ->where('status', '!=', 'cancelled')
            ->update(['status' => 'cancelled']);
    }
}
