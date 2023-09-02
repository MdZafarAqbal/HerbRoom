<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_id', 'attr_id', 'form', 'size', 'price', 'quantity', 'subtotal', 'tax', 'discount', 'total', 'coupon_id'];
  
  /**
   * Get the attribute that owns the order item.
   */
  public function attr()
  {
    return $this->belongsTo(Attribute::class, 'attr_id');
  }
  
  /**
   * Get the coupon that owns the order item.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }
  
  /**
   * Get the order that owns the order item.
   */
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}
