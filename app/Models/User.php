<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'u_num',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function seat()
    {
        return $this->hasOne(Seat::class,'seat_num');
    }
    public function sign()
    {
        return $this->hasMany(Sign::class, 'users_id'); 
    }
    public function queries()
    {
        return $this->hasMany(Query::class, 'users_id'); 
    }
    public function chat()
    {
        return $this->hasMany(Chat::class, 'users_id'); 
    }
    public function profile()
    {
        return $this->hasOne(Profile::class,'users_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class,'users_id');
    }

}