<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterClass;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $masterClasses = MasterClass::where('category_id', $category->id)
            ->upcoming()
            ->with(['master', 'bookings'])
            ->orderBy('date')
            ->orderBy('time_slot')
            ->get();
        return view('category', compact('category', 'masterClasses'));
    }
}