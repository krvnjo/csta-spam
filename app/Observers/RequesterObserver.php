<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Requester;

class RequesterObserver
{
    /**
     * Handle the Requester "created" event.
     */
    public function created(Requester $requester): void
    {
        (new Audit())
            ->logName('Add Requester')
            ->logDesc("A new requester: '{$requester->name}' has been added.")
            ->performedOn($requester)
            ->logEvent(1)
            ->logProperties([
                'name' => $requester->name,
                'requester ID' => $requester->req_num,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Requester "updated" event.
     */
    public function updated(Requester $requester): void
    {
        if ($requester->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($requester->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $requester->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$requester->isDirty('is_active')) {
                (new Audit())
                    ->logName('Edit Requester')
                    ->logDesc("The requester: '{$requester->name}' has been updated.")
                    ->performedOn($requester)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                $statusText = $requester->is_active == 1 ? 'Active' : 'Inactive';

                (new Audit())
                    ->logName('Set Requester Status')
                    ->logDesc("Updated the status of requester: '{$requester->name}' to {$statusText}.")
                    ->performedOn($requester)
                    ->logEvent(2)
                    ->logProperties([
                        'name' => $requester->name,
                        'requester ID' => $requester->req_num,
                        'status' => $statusText,
                    ])
                    ->log();
            }
        }
    }

    /**
     * Handle the Requester "deleted" event.
     */
    public function deleting(Requester $requester): void
    {
        (new Audit())
            ->logName('Delete Requester')
            ->logDesc("The requester: '{$requester->name}' has been permanently deleted.")
            ->performedOn($requester)
            ->logEvent(3)
            ->logProperties([
                'name' => $requester->name,
                'requester ID' => $requester->req_num,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
