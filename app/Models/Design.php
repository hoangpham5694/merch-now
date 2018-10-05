<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $table = 'designs';
    public $fillable = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function shirts()
    {
        return $this->hasMany(Shirt::class);
    }
    public function shirtsCount($status=''){
      if($status=='')
        return $this->shirts()->count();
      else
        return $this->shirts()->where('status','=',$status)->count();
    }
}
