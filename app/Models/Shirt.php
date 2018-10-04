<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{
  protected $table = 'shirts';
  public $fillable = [

  ];
  public function account()
  {
      return $this->belongsTo(Account::class);
  }
  public function user()
  {
      return $this->belongsTo(User::class);
  }
  public function design()
  {
      return $this->belongsTo(Design::class);
  }
}
