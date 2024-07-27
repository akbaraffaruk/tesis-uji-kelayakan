<?php

namespace App\Observers;

use App\Models\MemberCharacteristic;

class MemberCharacteristicObserver
{
    /**
     * Handle the MemberCharacteristic "creating" event.
     */
    public function creating(MemberCharacteristic $memberCharacteristic): void
    {
        $memberNumber = null;

        do {
            // Generate member number by this format "ddmmyy" + 4 random number
            $memberNumber = now()->format('dmY') . random_int(1000, 9999);

            // Check if member number already exists
            $exists = MemberCharacteristic::where('member_number', $memberNumber)->exists();
        } while ($exists);

        // Assign the unique member number to the model
        $memberCharacteristic->member_number = $memberNumber;
    }

    /**
     * Handle the MemberCharacteristic "updated" event.
     */
    public function updated(MemberCharacteristic $memberCharacteristic): void
    {
        //
    }

    /**
     * Handle the MemberCharacteristic "deleted" event.
     */
    public function deleted(MemberCharacteristic $memberCharacteristic): void
    {
        //
    }

    /**
     * Handle the MemberCharacteristic "restored" event.
     */
    public function restored(MemberCharacteristic $memberCharacteristic): void
    {
        //
    }

    /**
     * Handle the MemberCharacteristic "force deleted" event.
     */
    public function forceDeleted(MemberCharacteristic $memberCharacteristic): void
    {
        //
    }
}
