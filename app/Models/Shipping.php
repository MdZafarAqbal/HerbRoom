<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'ordered',
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_id', 'awb_no', 'fname', 'lname', 'cname', 'trn_no', 'phone', 'altphone', 'address', 'city_id', 'landmark', 'status', 'ordered', 'processed', 'shipped', 'delivered'];

  /**
   * Get the city that owns the shipping.
   */
  public function city()
  {
    return $this->belongsTo(City::class);
  }

  /**
   * Get the order that owns the shipping.
   */
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}
