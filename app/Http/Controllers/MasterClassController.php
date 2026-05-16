<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:master');
    }

    public function create()
    {
        $categories = Category::all();
        $occupiedSlots = auth()->user()->masterClasses()->get(['date', 'time_slot'])
            ->map(fn ($item) => $item->date.'|'.$item->time_slot)
            ->toArray();

        return view('master-class.create', compact('categories', 'occupiedSlots'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:9-11,11-13,13-15,15-17',
            'capacity' => 'required|integer|min:1|max:20',
            'cost' => 'required|numeric|min:0|max:5000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $exists = MasterClass::where('master_id', auth()->id())
            ->where('date', $request->date)
            ->where('time_slot', $request->time_slot)
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_slot' => 'Это время уже занято вашим другим мастер-классом.'])->withInput();
        }
        // Запрет создания МК с прошедшим временем сегодня
        if ($request->date === now()->toDateString()) {
            $slotEnd = match ($request->time_slot) {
                '9-11' => 11,
                '11-13' => 13,
                '13-15' => 15,
                '15-17' => 17,
                default => 0,
            };
            if (now()->hour >= $slotEnd) {
                return back()->withErrors(['time_slot' => 'Нельзя создать мастер-класс на уже прошедшее время сегодня.'])->withInput();
            }
        }

        MasterClass::create([
            'category_id' => $request->category_id,
            'master_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time_slot' => $request->time_slot,
            'capacity' => $request->capacity,
            'cost' => $request->cost,
        ]);

        return redirect()->route('cabinet')->with('success', 'Мастер-класс добавлен!');
    }

    public function edit(MasterClass $masterClass)
    {
        if ($masterClass->master_id !== auth()->id()) {
            abort(403);
        }

        return view('master-class.edit', compact('masterClass'));
    }

    public function update(Request $request, MasterClass $masterClass)
    {
        if ($masterClass->master_id !== auth()->id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:500',
            'cost' => 'required|numeric|min:0|max:5000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $masterClass->update([
            'description' => $request->description,
            'cost' => $request->cost,
        ]);

        return redirect()->route('cabinet')->with('success', 'Мастер-класс обновлён!');
    }
}
