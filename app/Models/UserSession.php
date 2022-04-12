<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $connection = 'mysql_telcloud';

    protected $fillable = [
        'ip',
        'token',
        'last_login'
    ];
}
