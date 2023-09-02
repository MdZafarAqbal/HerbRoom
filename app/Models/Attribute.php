<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
  
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'active', 
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['product_id', 'form_id', 'unit', 'size', 'price', 'coupon_id', 'status'];
  
  /**
   * Get the coupon that owns the attribute.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * Get the form that owns the attribute.
   */
  public function form()
  {
    return $this->belongsTo(Form::class);
  }

  /**
   * Get the product that owns the attribute.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  /**
   * Get the cancel items for the attribute.
   */
  public function cancel_items()
  {
    return $this->hasMany(CancelItem::class, 'attr_id');
  }
  
  /**
   * Get the cart items for the attribute.
   */
  public function cart_items()
  {
    return $this->hasMany(CartItem::class, 'attr_id');
  }

  /**
   * Get the order items for the attribute.
   */
  public function order_items()
  {
    return $this->hasMany(OrderItem::class, 'attr_id');
  }

  /**
   * Get the return items for the attribute.
   */
  public function return_items()
  {
    return $this->hasMany(ReturnItem::class, 'attr_id');
  }
}

