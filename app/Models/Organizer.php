<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model 
{
    protected $table = 'organizers';

    protected $hidden = [
        'password', 'remember_token'
    ];
}