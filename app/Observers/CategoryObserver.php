<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        activity()
            ->useLog('Add Category')
            ->performedOn($category)
            ->event('created')
            ->withProperties([
                'name' => $category->name,
                'status' => 'Active',
            ])
            ->log("A new brand: '{$category->name}' has been created.");
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        if (!$category->isDirty('is_active')) {
            activity()
                ->useLog('Edit Category')
                ->performedOn($category)
                ->event('updated')
                ->withProperties([
                    'old' => [
                        'name' => $category->getOriginal('name'),
                    ],
                    'new' => [
                        'name' => $category->name,
                    ],
                ])
                ->log("The brand: '{$category->name}' has been updated.");
        } else {
            $statusText = $category->is_active == 1 ? 'Active' : 'Inactive';

            activity()
                ->useLog('Set Category Status')
                ->performedOn($category)
                ->event('updated')
                ->withProperties([
                    'name' => $category->name,
                    'status' => $statusText,
                ])
                ->log("Updated the status of brand: '{$category->name}' to {$statusText}.");
        }
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        activity()
            ->useLog('Delete Category')
            ->performedOn($category)
            ->event('deleted')
            ->withProperties([
                'name' => $category->name,
                'status' => 'Deleted',
            ])
            ->log("The brand: '{$category->name}' has been permanently deleted.");
    }
}
