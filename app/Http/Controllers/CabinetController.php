<?php

namespace App\Http\Controllers;

use App\Models\MasterClass;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:master');
    }

    public function index()
    {
        $master = auth()->user();
        $masterClasses = $master->masterClasses()->with('bookings.user')->orderBy('date', 'desc')->get();
        return view('cabinet', compact('master', 'masterClasses'));
    }
}