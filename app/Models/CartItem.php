<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
  use MassPrunable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'attr_id', 'quantity', 'subtotal', 'tax', 'discount', 'total', 'coupon_id'];

  /**
   * Get the prunable model query.
   */
  public function prunable(): Builder
  {
    return static::where('created_at', '<=', now()->subMonth());
  }

  /**
   * Get the attribute that owns the cart item.
   */
  public function attr()
  {
    return $this->belongsTo(Attribute::class, 'attr_id');
  }

  /**
   * Get the coupon that owns the cart item.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * Get the user that owns the cart item.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
