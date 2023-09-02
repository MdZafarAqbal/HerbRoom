<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'new'
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_no', 'user_id', 'fname', 'lname', 'cname', 'trn_no', 'email', 'phone', 'altphone', 'address', 'city_id', 'landmark', 'coupon_id', 'status'];
  
  /**
   * Get the city that owns the order.
   */
  public function city()
  {
    return $this->belongsTo(City::class);
  }

  /**
   * Get the coupon that owns the order.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * Get the user that owns the order.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Get the cancel items for the order.
   */
  public function cancel_items()
  {
    return $this->hasMany(CancelItem::class);
  }

  /**
   * Get the order items for the order.
   */
  public function order_items()
  {
    return $this->hasMany(OrderItem::class);
  }
  
  /**
   * Get the return items for the order.
   */
  public function return_items()
  {
    return $this->hasMany(ReturnItem::class);
  }

  /**
   * Get the payment associated with the order.
   */
  public function payment()
  {
    return $this->hasOne(Payment::class);
  }
  
  /**
   * Get the shipping associated with the order.
   */
  public function shipping()
  {
    return $this->hasOne(Shipping::class);
  }
}
