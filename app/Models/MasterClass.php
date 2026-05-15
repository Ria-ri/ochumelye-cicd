<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'master_id', 'title', 'description',
        'date', 'time_slot', 'capacity', 'cost'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function freePlaces()
    {
        return $this->capacity - $this->bookings()->count();
    }

    public function isFull()
    {
        return $this->freePlaces() <= 0;
    }

    public function isPassed()
    {
    $currentTime = now();
    $mcDate = \Carbon\Carbon::parse($this->date);

    // Если дата в прошлом – точно прошёл
    if ($mcDate->isPast()) {
        return true;
    }
    // Если дата сегодня проверяем время окончания слота
    if ($mcDate->isToday()) {
        $end = match ($this->time_slot) {
            '9-11'  => 11,
            '11-13' => 13,
            '13-15' => 15,
            '15-17' => 17,
            default => 0,
        };
        $currentHour = (int) $currentTime->format('H');
        if ($currentHour >= $end) {
            return true; // слот уже закончился
        }
    }
    return false;
    }

    public function scopeUpcoming($query)
    {
    $now = now();
    $today = $now->toDateString();

    return $query->where(function ($q) use ($today, $now) {
        // будущие даты
        $q->where('date', '>', $today)
          // или сегодня, но слот ещё не закончился
          ->orWhere(function ($q2) use ($today, $now) {
              $q2->where('date', '=', $today)
                 ->where(function ($q3) use ($now) {
                     $hour = (int) $now->format('H');
                     $q3->where('time_slot', '9-11')->whereRaw("? < 11", [$hour])
                        ->orWhere('time_slot', '11-13')->whereRaw("? < 13", [$hour])
                        ->orWhere('time_slot', '13-15')->whereRaw("? < 15", [$hour])
                        ->orWhere('time_slot', '15-17')->whereRaw("? < 17", [$hour]);
                 });
          });
    });
}
}