<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        (new Audit())
            ->logName('Add User')
            ->logDesc("A new user: '{$user->name}' has been created.")
            ->performedOn($user)
            ->logEvent(1)
            ->logProperties([
                'name' => $user->name,
                'username' => $user->user_name,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($user->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $user->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$user->isDirty('is_active')) {
                (new Audit())
                    ->logName('Edit User')
                    ->logDesc("The user: '{$user->name}' has been updated.")
                    ->performedOn($user)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                $statusText = $user->is_active == 1 ? 'Active' : 'Inactive';

                (new Audit())
                    ->logName('Set User Status')
                    ->logDesc("Updated the status of user: '{$user->name}' to {$statusText}.")
                    ->performedOn($user)
                    ->logEvent(2)
                    ->logProperties([
                        'name' => $user->name,
                        'username' => $user->user_name,
                        'status' => $statusText,
                    ])
                    ->log();
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        (new Audit())
            ->logName('Delete User')
            ->logDesc("The user: '{$user->name}' has been permanently deleted.")
            ->performedOn($user)
            ->logEvent(3)
            ->logProperties([
                'name' => $user->name,
                'username' => $user->user_name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
