<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory,SoftDeletes;


    protected $table = 'events';
    protected $guarded = ['id'];

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
