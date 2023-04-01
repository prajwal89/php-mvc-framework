<?php

namespace App\Models;

use App\Core\Abstract\Model;
use App\Core\Traits\Authenticatable;

class User extends Model
{
    use Authenticatable;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
