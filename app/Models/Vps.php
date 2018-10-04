<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vps extends Model
{
    protected $table = 'vpss';

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
