<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Brand;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     */
    public function created(Brand $brand): void
    {
        (new Audit())
            ->logName('Add Brand')
            ->logDesc("A new brand: '{$brand->name}' has been created.")
            ->performedOn($brand)
            ->logEvent(1)
            ->logProperties([
                'name' => $brand->name,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Brand "updated" event.
     */
    public function updated(Brand $brand): void
    {
        if (!$brand->isDirty('is_active')) {
            (new Audit())
                ->logName('Edit Brand')
                ->logDesc("The brand: '{$brand->name}' has been updated.")
                ->performedOn($brand)
                ->logEvent(2)
                ->logProperties([
                    'old' => [
                        'name' => $brand->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $brand->name,
                    ],
                ])
                ->log();
        } else {
            $statusText = $brand->is_active == 1 ? 'Active' : 'Inactive';

            (new Audit())
                ->logName('Set Brand Status')
                ->logDesc("Updated the status of brand: '{$brand->name}' to {$statusText}.")
                ->performedOn($brand)
                ->logEvent(2)
                ->logProperties([
                    'name' => $brand->name,
                    'status' => $statusText,
                ])
                ->log();
        }
    }

    /**
     * Handle the Brand "deleted" event.
     */
    public function deleted(Brand $brand): void
    {
        (new Audit())
            ->logName('Delete Brand')
            ->logDesc("The brand: '{$brand->name}' has been permanently deleted.")
            ->performedOn($brand)
            ->logEvent(3)
            ->logProperties([
                'name' => $brand->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
