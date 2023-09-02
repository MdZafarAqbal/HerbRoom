<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  /**
   * Indicates if the model's ID is auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'inactive'
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id', 'name', 'state_id', 'country_id', 'shipping', 'status'];
 
  /**
   * Get the country that owns the city.
   */
  public function country()
  {
    return $this->belongsTo(Country::class);
  }
  
  /**
   * Get the state that owns the city.
   */
  public function state()
  {
    return $this->belongsTo(State::class);
  }

  /**
   * Get the addresses for the city.
   */
  public function addresses()
  {
    return $this->hasMany(Address::class);
  }

  /**
   * Get the orders for the city.
   */
  public function orders()
  {
    return $this->hasMany(Order::class);
  }
  
  /**
   * Get the shippings for the city.
   */
  public function shippings()
  {
    return $this->hasMany(Shipping::class);
  }
}