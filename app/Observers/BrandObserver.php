<?php

namespace App\Observers;

use App\Models\Brand;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        activity()
            ->useLog('Add Brand')
            ->performedOn($brand)
            ->event('created')
            ->withProperties([
                'name' => $brand->name,
                'status' => 'Active',
            ])
            ->log("A new brand: '{$brand->name}' has been created.");
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        if (!$brand->isDirty('is_active')) {
            activity()
                ->useLog('Edit Brand')
                ->performedOn($brand)
                ->event('updated')
                ->withProperties([
                    'old' => [
                        'name' => $brand->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $brand->name,
                    ],
                ])
                ->log("The brand: '{$brand->name}' has been updated.");
        } else {
            $statusText = $brand->is_active == 1 ? 'Active' : 'Inactive';

            activity()
                ->useLog('Set Brand Status')
                ->performedOn($brand)
                ->event('updated')
                ->withProperties([
                    'name' => $brand->name,
                    'status' => $statusText,
                ])
                ->log("Updated the status of brand: '{$brand->name}' to {$statusText}.");
        }
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        activity()
            ->useLog('Delete Brand')
            ->performedOn($brand)
            ->event('deleted')
            ->withProperties([
                'name' => $brand->name,
                'status' => 'Deleted',
            ])
            ->log("The brand: '{$brand->name}' has been permanently deleted.");
    }
}
