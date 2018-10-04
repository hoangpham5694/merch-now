<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'admin_users';
    public function designs()
    {
        return $this->hasMany(Design::class);
    }
}
