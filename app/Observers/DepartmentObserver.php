<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        activity()
            ->useLog('Add Department')
            ->performedOn($department)
            ->event('created')
            ->withProperties([
                'name' => $department->name,
                'code' => $department->code,
                'status' => 'Active',
            ])
            ->log("A new department: '{$department->name}' has been created.");
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $department): void
    {
        if (!$department->isDirty('is_active')) {
            activity()
                ->useLog('Edit Department')
                ->performedOn($department)
                ->event('updated')
                ->withProperties([
                    'old' => [
                        'name' => $department->getOriginal('name'),
                        'code' => $department->getOriginal('code'),
                    ],
                    'new' => [
                        'name' => $department->name,
                        'code' => $department->code,
                    ],
                ])
                ->log("The department: '{$department->name}' has been updated.");
        } else {
            $statusText = $department->is_active == 1 ? 'Active' : 'Inactive';

            activity()
                ->useLog('Set Department Status')
                ->performedOn($department)
                ->event('updated')
                ->withProperties([
                    'name' => $department->name,
                    'status' => $statusText,
                ])
                ->log("Updated the status of department: '{$department->name}' to {$statusText}.");
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Department $department): void
    {
        activity()
            ->useLog('Delete Department')
            ->performedOn($department)
            ->event('deleted')
            ->withProperties([
                'name' => $department->name,
                'status' => 'Deleted',
            ])
            ->log("The department: '{$department->name}' has been permanently deleted.");
    }
}
