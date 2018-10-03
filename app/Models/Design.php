<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $table = 'designs';
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
