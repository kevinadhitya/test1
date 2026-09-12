<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'username',
        'preferred_timezone',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'creator_id');
    }

    public function invitedAppointments()
    {
        return $this->belongsToMany(Appointment::class, 'appointment_user');
    }
}
