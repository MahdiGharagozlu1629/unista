<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'family',
        'phone',
        'national_code',
        'student_code'
    ];

    protected $hidden = [
        'password'
    ];
}
