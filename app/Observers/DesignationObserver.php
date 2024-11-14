<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Designation;

class DesignationObserver
{
    /**
     * Handle the Designation "created" event.
     */
    public function created(Designation $designation): void
    {
        (new Audit())
            ->logName('Add Designation')
            ->logDesc("A new designation: '{$designation->name}' has been created.")
            ->performedOn($designation)
            ->logEvent(1)
            ->logProperties([
                'name' => $designation->name,
                'department' => $designation->department->name,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Designation "updated" event.
     */
    public function updated(Designation $designation): void
    {
        if (!$designation->isDirty('is_active')) {
            (new Audit())
                ->logName('Edit Designation')
                ->logDesc("The designation: '{$designation->name}' has been updated.")
                ->performedOn($designation)
                ->logEvent(2)
                ->logProperties([
                    'old' => [
                        'name' => $designation->getOriginal('name'),
                        'department' => $designation->department->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $designation->name,
                        'department' => $designation->department->name,
                    ],
                ])
                ->log();
        } else {
            $statusText = $designation->is_active == 1 ? 'Active' : 'Inactive';

            (new Audit())
                ->logName('Set Designation Status')
                ->logDesc("Updated the status of designation: '{$designation->name}' to {$statusText}.")
                ->performedOn($designation)
                ->logEvent(2)
                ->logProperties([
                    'name' => $designation->name,
                    'status' => $statusText,
                ])
                ->log();
        }
    }

    /**
     * Handle the Designation "deleting" event.
     */
    public function deleting(Designation $designation): void
    {
        (new Audit())
            ->logName('Delete Designation')
            ->logDesc("The designation: '{$designation->name}' has been permanently deleted.")
            ->performedOn($designation)
            ->logEvent(3)
            ->logProperties([
                'name' => $designation->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
