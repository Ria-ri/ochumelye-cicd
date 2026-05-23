<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read Collection<int, MasterClass> $masterClasses
 * @property-read Collection<int, Booking> $bookings
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
        $avatarPath = public_path('img/masters/'.$this->id.'.png');
        if (file_exists($avatarPath)) {
            return asset('img/masters/'.$this->id.'.png');
        }

        return asset('img/driver1.png');
    }
}
