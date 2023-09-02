<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
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
  protected $fillable = ['name', 'slug', 'cat_id', 'coupon_id', 'status'];
  
  /**
   * Get the category that owns the subcategory.
   */
  public function cat()
  {
    return $this->belongsTo(Category::class, 'cat_id');
  }

  /**
   * Get the coupon that owns the product.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * The products that belong to the subcategory.
   */ 
  public function products()
  {
    return $this->belongsToMany(Product::class, 'category_product', 'subcat_id', 'product_id');
  }
}
