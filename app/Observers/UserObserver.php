<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        activity()
            ->useLog('Add User')
            ->performedOn($user)
            ->event('Created')
            ->withProperties([
                'name' => $user->fname . ' ' . $user->lname,
                'username' => $user->user_name,
                'status' => 'Active',
            ])
            ->log("A new user: '{$user->user_name}' has been created.");
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
                activity()
                    ->useLog('Edit User')
                    ->performedOn($user)
                    ->event('Updated')
                    ->withProperties($changes)
                    ->log("The user: '{$user->user_name}' has been updated.");
            } else {
                $statusText = $user->is_active == 1 ? 'Active' : 'Inactive';

                activity()
                    ->useLog('Set User Status')
                    ->performedOn($user)
                    ->event('Updated')
                    ->withProperties([
                        'name' => $user->fname . ' ' . $user->lname,
                        'username' => $user->user_name,
                        'status' => $statusText,
                    ])
                    ->log("Updated the status of user: '{$user->user_name}' to {$statusText}.");
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        activity()
            ->useLog('Delete User')
            ->performedOn($user)
            ->event('Deleted')
            ->withProperties([
                'name' => $user->fname . ' ' . $user->lname,
                'username' => $user->user_name,
                'status' => 'Deleted',
            ])
            ->log("The user: '{$user->user_name}' has been permanently deleted.");
    }
}
