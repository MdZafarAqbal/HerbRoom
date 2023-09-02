<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
  protected $fillable = ['name', 'slug', 'coupon_id', 'status'];

  /**
   * Get the coupon that owns the category.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * The products that belong to the category.
  */
  public function products()
  {
    return $this->belongsToMany(Product::class, 'category_product', 'cat_id', 'product_id');
  }

  /**
   * Get the subcategories for the category.
   */
  public function subcats()
  {
    return $this->hasMany(SubCategory::class, 'cat_id');
  }
}