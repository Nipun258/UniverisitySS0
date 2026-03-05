<?php

namespace App\Http\Controllers;

use App\Models\Category;

abstract class Controller
{
    public function getCategories(array $categoryIds)
    {
        $results = Category::whereIn('category_type_id', $categoryIds)->orderBy('sorting_order', 'ASC')->get();
        return $results;
    }
}
