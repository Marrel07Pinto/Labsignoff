<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentlab extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id'); 
    }
    public function queries()
    {
        return $this->hasMany(Query::class, 'queries_id'); 
    }
    public function sign()
    {
        return $this->hasMany(Sign::class, 'signs_id'); 
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'feedbacks_id'); 
    }
}
