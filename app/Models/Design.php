<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $table = 'designs';
    public $fillable = [
        'brand',
        'status'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
