<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Coupon extends Model
{
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'type' => 'percent'
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['code', 'type', 'value', 'threshold', 'effect'];
  
  /**
   * Get the attributes for the coupon.
  */
  public function attrs()
  {
    return $this->hasMany(Attribute::class);
  }
   
  /**
   * Get the cart items for the coupon.
  */
  public function cart_items()
  {
    return $this->hasMany(CartItem::class);
  }

  /**
   * Get the categories for the coupon.
  */
  public function cats()
  {
    return $this->hasMany(Category::class);
  }

  /**
   * Get the order items for the coupon.
  */
  public function order_items()
  {
    return $this->hasMany(OrderItem::class);
  }
  
  /**
   * Get the orders for the coupon.
  */
  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  /**
   * Get the products for the coupon.
  */
  public function products()
  {
    return $this->hasMany(Product::class);
  }

  /**
   * Get the subcategories for the coupon.
  */
  public function subcats()
  {
    return $this->hasMany(SubCategory::class);
  }
  
  /**
   * Get the users for the coupon.
  */
  public function users()
  {
    return $this->hasMany(User::class);
  }
}
