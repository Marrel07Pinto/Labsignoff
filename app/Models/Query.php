<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'id'); 
    }
    public function Seat()
    {
        return $this->belongsTo(Seat::class, 'seat_num'); 
    }
    
}
