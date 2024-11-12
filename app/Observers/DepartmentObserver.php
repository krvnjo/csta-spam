<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Department;

class DepartmentObserver
{
    /**
     * Handle the Department "created" event.
     */
    public function created(Department $department): void
    {
        (new Audit())
            ->logName('Add Department')
            ->logDesc("A new department: '{$department->name}' has been created.")
            ->performedOn($department)
            ->logEvent(1)
            ->logProperties([
                'name' => $department->name,
                'code' => $department->code,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Department "updated" event.
     */
    public function updated(Department $department): void
    {
        if (!$department->isDirty('is_active')) {
            (new Audit())
                ->logName('Edit Department')
                ->logDesc("The department: '{$department->name}' has been updated.")
                ->performedOn($department)
                ->logEvent(2)
                ->logProperties([
                    'old' => [
                        'name' => $department->getOriginal('name'),
                        'code' => $department->getOriginal('code'),
                    ],
                    'new' => [
                        'name' => $department->name,
                        'code' => $department->code,
                    ],
                ])
                ->log();
        } else {
            $statusText = $department->is_active == 1 ? 'Active' : 'Inactive';

            (new Audit())
                ->logName('Set Department Status')
                ->logDesc("Updated the status of department: '{$department->name}' to {$statusText}.")
                ->performedOn($department)
                ->logEvent(2)
                ->logProperties([
                    'name' => $department->name,
                    'status' => $statusText,
                ])
                ->log();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Department $department): void
    {
        (new Audit())
            ->logName('Delete Department')
            ->logDesc("The department: '{$department->name}' has been permanently deleted.")
            ->performedOn($department)
            ->logEvent(3)
            ->logProperties([
                'name' => $department->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
