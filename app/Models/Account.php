<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
    public $fillable = [
        'name',
        'status'
    ];
    public function vps()
    {
        return $this->belongsTo(Vps::class);
    }
    public function designs()
    {
        return $this->hasMany(Account::class);
    }
}
