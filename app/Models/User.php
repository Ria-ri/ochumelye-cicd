<?php

namespace App\Models;
use App\Models\MasterClass;
use App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MasterClass> $masterClasses
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Booking> $bookings
 * @property-read \App\Models\Booking|null $bookings
 */

class User extends Authenticatable

{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isMaster()
    {
        return $this->role === 'master';
    }

    public function masterClasses()
    {
        return $this->hasMany(MasterClass::class, 'master_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function getAvatarAttribute()
    {
        $avatarPath = public_path('img/masters/' . $this->id . '.png');
        if (file_exists($avatarPath)) {
            return asset('img/masters/' . $this->id . '.png');
        }
        return asset('img/driver1.png'); // заглушка
    }
    
}