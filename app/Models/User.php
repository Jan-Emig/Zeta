<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'mysql_telcloud';

    protected $fillable = [
        'username',
        'password',
        'uuid'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public static function getMaxUsernameLength() { return 30; }
}
