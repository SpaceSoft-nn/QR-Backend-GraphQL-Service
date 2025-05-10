<?php

namespace App\Observers;

use App\Modules\PersonalArea\Domain\Models\PersonalArea;

class PersonalAreaObserver
{
    /**
     * Handle the PersonalArea "created" event.
     */
    public function created(PersonalArea $personalArea): void
    {
        //
    }

    /**
     * Handle the PersonalArea "updated" event.
     */
    public function updated(PersonalArea $personalArea): void
    {
        //
    }

    /**
     * Handle the PersonalArea "deleted" event.
     */
    public function deleted(PersonalArea $personalArea): void
    {
        //
    }

    /**
     * Handle the PersonalArea "restored" event.
     */
    public function restored(PersonalArea $personalArea): void
    {
        //
    }

    /**
     * Handle the PersonalArea "force deleted" event.
     */
    public function forceDeleted(PersonalArea $personalArea): void
    {
        //
    }
}
