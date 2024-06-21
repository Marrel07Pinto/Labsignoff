<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $fillable = ['users_id', 'seat_num'];
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
    public function queries()
    {
        return $this->hasMany(Query::class, 'q_seat'); 
    }
}
