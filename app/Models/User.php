<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, Authorizable
{
  use HasRoles, Notifiable;

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'type' => 'user',
    'status' => 'active'
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   *
   * 
   */
  protected $fillable = ['fname', 'lname', 'cname', 'trn_no', 'email', 'password', 'type', 'coupon_id', 'status'];
  
  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['password', 'remember_token'];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  /**
   * Get the coupon that owns the user.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * Get the cart items for the user.
   */
  public function cart_items()
  {
    return $this->hasMany(CartItem::class);
  }
  
  /**
   * Get the orders for the user.
   */
  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  /**
   * Get the reviews for the user.
   */
  public function reviews()
  {
    return $this->hasMany(Review::class);
  }

  /**
   * Get the wishlists for the user.
   */
  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  /**
   * Get the address associated with the user.
   */
  public function address()
  {
    return $this->hasOne(Address::class);
  }
}
