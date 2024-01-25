<?php

namespace App\Observers;

use Illuminate\Support\Str;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     * Antes de cadastrar
     */
    public function creating(Category $category): void
    {
        $category->url = Str::slug($category->title, '-');
    }

    /**
     * Handle the Category "updated" event.
     * Antes de atualizar
     */
    public function updating(Category $category): void
    {
        $category->url = Str::slug($category->title, '-');
    }

    /**
     * Handle the Category "deleted" event.
     * Antes de deletar
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
