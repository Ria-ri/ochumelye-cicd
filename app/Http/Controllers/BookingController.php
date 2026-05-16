<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MasterClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function confirmForm(MasterClass $masterClass)
    {
        $user = auth()->user();

        // Запрет записи мастера на свой МК
        if ($user->id === $masterClass->master_id) {
            return redirect()->back()->with('error', 'Вы не можете записаться на собственный мастер-класс.');
        }

        if ($masterClass->isFull()) {
            return redirect()->back()->with('error', 'Нет свободных мест.');
        }

        $alreadyBooked = Booking::where('user_id', $user->id)
            ->where('master_class_id', $masterClass->id)
            ->exists();

        if ($alreadyBooked) {
            return redirect()->back()->with('error', 'Вы уже записаны на этот мастер-класс.');
        }
        if ($masterClass->isPassed()) {
            return redirect()->route('category.show', $masterClass->category_id)
                ->with('error', 'Этот мастер-класс уже прошёл, запись невозможна.');
        }

        return view('booking.confirm', compact('masterClass', 'user'));
    }

    public function confirm(Request $request, MasterClass $masterClass)
    {
        $user = auth()->user();

        // Запрет записи мастера на свой МК
        if ($user->id === $masterClass->master_id) {
            return redirect()->back()->with('error', 'Вы не можете записаться на собственный мастер-класс.');
        }

        DB::beginTransaction();
        try {
            if ($masterClass->isFull()) {
                throw new \Exception('Места закончились.');
            }

            $exists = Booking::where('user_id', $user->id)
                ->where('master_class_id', $masterClass->id)
                ->exists();

            if ($exists) {
                throw new \Exception('Вы уже записаны.');
            }
            if ($masterClass->isPassed()) {
                return redirect()->route('category.show', $masterClass->category_id)
                    ->with('error', 'Этот мастер-класс уже прошёл, запись невозможна.');
            }

            Booking::create([
                'user_id' => $user->id,
                'master_class_id' => $masterClass->id,
            ]);

            DB::commit();

            return redirect()->route('category.show', $masterClass->category_id)
                ->with('success', 'Вы успешно записались на мастер-класс!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(MasterClass $masterClass)
    {
        return redirect()->route('category.show', $masterClass->category_id)
            ->with('info', 'Вы отменили запись.');
    }
}
