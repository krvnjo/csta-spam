<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        (new Audit())
            ->logName('Add Role')
            ->logDesc("A new role: '{$role->name}' has been created.")
            ->performedOn($role)
            ->logEvent(1)
            ->logProperties([
                'name' => $role->name,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        if ($role->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($role->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $role->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$role->isDirty('is_active')) {
                (new Audit())
                    ->logName('Edit Role')
                    ->logDesc("The role: '{$role->name}' has been updated.")
                    ->performedOn($role)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                $statusText = $role->is_active == 1 ? 'Active' : 'Inactive';

                (new Audit())
                    ->logName('Set Role Status')
                    ->logDesc("Updated the status of role: '{$role->name}' to {$statusText}.")
                    ->performedOn($role)
                    ->logEvent(2)
                    ->logProperties([
                        'name' => $role->name,
                        'status' => $statusText,
                    ])
                    ->log();
            }
        }
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        (new Audit())
            ->logName('Delete Role')
            ->logDesc("The role: '{$role->name}' has been permanently deleted.")
            ->performedOn($role)
            ->logEvent(3)
            ->logProperties([
                'name' => $role->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
