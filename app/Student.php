<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'middle_name','last_name','mobile', 'gender', 'email', 'password', 'image'
    ];

    protected $hidden = [
        'password',
    ];

}
