<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = [
        'lab',
        'f_understanding',
        'f_confusing',
        'f_interesting',
        'f_engaging',
        'f_important',
        'f_overall',
        'f_difficulty',
    ];
}
