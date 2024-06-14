<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    protected $primaryKey ='seat_num';
    protected $fillable = ['value'];
    public function user()
    {
        return $this->hasOne(User::class,'seat_num');
    }
}
