<?php

namespace App\Observers;

use App\Models\Audit;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        (new Audit())
            ->logName('Add Category')
            ->logDesc("A new category: '{$category->name}' has been created.")
            ->performedOn($category)
            ->logEvent(1)
            ->logProperties([
                'name' => $category->name,
                'status' => 'Active',
            ])
            ->log();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        if (!$category->isDirty('is_active')) {
            (new Audit())
                ->logName('Edit Category')
                ->logDesc("The category: '{$category->name}' has been updated.")
                ->performedOn($category)
                ->logEvent(2)
                ->logProperties([
                    'old' => [
                        'name' => $category->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $category->name,
                    ],
                ])
                ->log();
        } else {
            $statusText = $category->is_active == 1 ? 'Active' : 'Inactive';

            (new Audit())
                ->logName('Set Category Status')
                ->logDesc("Updated the status of category: '{$category->name}' to {$statusText}.")
                ->performedOn($category)
                ->logEvent(2)
                ->logProperties([
                    'name' => $category->name,
                    'status' => $statusText,
                ])
                ->log();
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        (new Audit())
            ->logName('Delete Category')
            ->logDesc("The category: '{$category->name}' has been permanently deleted.")
            ->performedOn($category)
            ->logEvent(3)
            ->logProperties([
                'name' => $category->name,
                'status' => 'Deleted',
            ])
            ->log();
    }
}
