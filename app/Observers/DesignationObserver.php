<?php

namespace App\Observers;

use App\Models\Designation;

class DesignationObserver
{
    /**
     * Handle the Designation "created" event.
     */
    public function created(Designation $designation): void
    {
        activity()
            ->useLog('Add Designation')
            ->performedOn($designation)
            ->event('created')
            ->withProperties([
                'name' => $designation->name,
                'department' => $designation->department->name,
                'status' => 'Active',
            ])
            ->log("A new designation: '{$designation->name}' has been created.");
    }

    /**
     * Handle the Designation "updated" event.
     */
    public function updated(Designation $designation): void
    {
        if (!$designation->isDirty('is_active')) {
            activity()
                ->useLog('Edit Designation')
                ->performedOn($designation)
                ->event('updated')
                ->withProperties([
                    'old' => [
                        'name' => $designation->getOriginal('name'),
                        'department' => $designation->department->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $designation->name,
                        'department' => $designation->department->name,
                    ],
                ])
                ->log("The designation: '{$designation->name}' has been updated.");
        } else {
            $statusText = $designation->is_active == 1 ? 'Active' : 'Inactive';

            activity()
                ->useLog('Set Designation Status')
                ->performedOn($designation)
                ->event('updated')
                ->withProperties([
                    'name' => $designation->name,
                    'status' => $statusText,
                ])
                ->log("Updated the status of designation: '{$designation->name}' to {$statusText}.");
        }
    }

    /**
     * Handle the Designation "deleted" event.
     */
    public function deleted(Designation $designation): void
    {
        activity()
            ->useLog('Delete Designation')
            ->performedOn($designation)
            ->event('deleted')
            ->withProperties([
                'name' => $designation->name,
                'status' => 'Deleted',
            ])
            ->log("The designation: '{$designation->name}' has been permanently deleted.");
    }
}
