<?php

namespace App\Models;

use App\Core\ModelBase;
use App\Core\Traits\Authenticatable;

class User extends ModelBase
{
    use Authenticatable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
