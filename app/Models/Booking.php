<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'master_class_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class);
    }
}
