<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $userBookings = [];
        if (auth()->check()) {
            $userBookings = auth()->user()->bookings()->with('masterClass')->get();
        }

        return view('home', compact('categories', 'userBookings'));
    }
}
