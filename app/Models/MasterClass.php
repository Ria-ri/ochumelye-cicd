<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'master_id', 'title', 'description',
        'date', 'time_slot', 'capacity', 'cost',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
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
        $mcDate = Carbon::parse($this->date);

        if ($mcDate->isPast()) {
            return true;
        }

        if ($mcDate->isToday()) {
            $end = match ($this->time_slot) {
                '9-11' => 11,
                '11-13' => 13,
                '13-15' => 15,
                '15-17' => 17,
            };
            $currentHour = (int) $currentTime->format('H');
            if ($currentHour >= $end) {
                return true;
            }
        }

        return false;
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }
}
