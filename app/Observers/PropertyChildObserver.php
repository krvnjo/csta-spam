<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\PropertyChild;

class PropertyChildObserver
{
    /**
     * Handle the PropertyChild "updated" event.
     */
    public function updated(PropertyChild $propertyChild): void
    {
        if ($propertyChild->isDirty()) {
            $changes = [
                'old' => [],
                'new' => []
            ];

            foreach ($propertyChild->getDirty() as $attribute => $newValue) {
                if ($attribute === 'is_active' || $attribute === 'updated_at') {
                    continue;
                }

                $oldValue = $propertyChild->getOriginal($attribute);

                $changes['old'][$attribute] = $oldValue;
                $changes['new'][$attribute] = $newValue;
            }

            if (!$propertyChild->isDirty('is_active')) {
                (new Audit())
                    ->logName('Edit Item')
                    ->logDesc("The item: '{$propertyChild->name}' has been updated.")
                    ->performedOn($propertyChild)
                    ->logEvent(2)
                    ->logProperties($changes)
                    ->log();
            } else {
                $statusText = $propertyChild->is_active == 1 ? 'Active' : 'Inactive';

                (new Audit())
                    ->logName('Set Item Status')
                    ->logDesc("Updated the status of the item: '{$propertyChild->prop_code}' to {$statusText}.")
                    ->performedOn($propertyChild)
                    ->logEvent(2)
                    ->logProperties([
                        'name' => $propertyChild->property->name,
                        'item code' => $propertyChild->prop_code,
                        'status' => $statusText,
                    ])
                    ->log();
            }
        }
    }

    /**
     * Handle the PropertyChild "deleted" event.
     */
    public function deleting(PropertyChild $propertyChild): void
    {
        (new Audit())
            ->logName('Delete Item')
            ->logDesc("The item: '{$propertyChild->prop_code}' has been permanently deleted.")
            ->performedOn($propertyChild)
            ->logEvent(3)
            ->logProperties([
                'name' => $propertyChild->property->name,
                'item number' => $propertyChild->prop_code,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
