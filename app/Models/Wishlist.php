<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'product_id'];
  
  /**
   * Get the product that owns the wishlist.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  /**
   * Get the user that owns the wishlist.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
