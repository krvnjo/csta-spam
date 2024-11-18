<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\PropertyParent;

class PropertyParentObserver
{
    /**
     * Handle the PropertyParent "created" event.
     */
    public function created(PropertyParent $propertyParent): void
    {
        (new Audit())
            ->logName('Add Item')
            ->logDesc("A new item: '{$propertyParent->name}' has been created.")
            ->performedOn($propertyParent)
            ->logEvent(1)
            ->logProperties([
                'name' => $propertyParent->name,
                'quantity' => $propertyParent->quantity,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the PropertyParent "updated" event.
     */
    public function updated(PropertyParent $propertyParent): void
    {
        $changes = [
            'old' => [],
            'new' => []
        ];

        foreach ($propertyParent->getDirty() as $attribute => $newValue) {
            if ($attribute === 'is_active' || $attribute === 'updated_at') {
                continue;
            }

            $oldValue = $propertyParent->getOriginal($attribute);

            $changes['old'][$attribute] = $oldValue;
            $changes['new'][$attribute] = $newValue;
        }

        (new Audit())
            ->logName('Edit Item')
            ->logDesc("The item: '{$propertyParent->name}' has been updated.")
            ->performedOn($propertyParent)
            ->logEvent(2)
            ->logProperties($changes)
            ->log();
    }
}
