<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'active'
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'phone', 'altphone', 'address', 'city_id', 'landmark', 'status'];
  
  /**
   * Get the city that owns the order.
   */
  public function city()
  {
    return $this->belongsTo(City::class);
  }

  /**
   * Get the user that owns the order.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
