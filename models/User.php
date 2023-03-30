<?php

namespace App\Models;

use App\Core\ModelBase;

class User extends ModelBase
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
