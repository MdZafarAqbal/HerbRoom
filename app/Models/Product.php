<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
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
   *
   * 
   */
  protected $fillable = ['name', 'slug', 'sci_name', 'other_name', 'description', 'details', 'photo', 'minprice', 'coupon_id', 'status'];
  
  /**
   * Get the coupon that owns the product.
   */
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }

  /**
   * The brands that belong to the product.
  */
  public function brands()
  {
    return $this->belongsToMany(Brand::class);
  }

  /**
   * The categories that belong to the product.
  */
  public function cats()
  {
    return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'cat_id');
  }

  /**
   * The forms that belong to the product.
  */
  public function forms()
  {
    return $this->belongsToMany(Form::class);
  }
  
  /**
   * The promotions that belong to the product.
   */
  public function promotions()
  {
    return $this->belongsToMany(Promotion::class);
  }

  /**
   * The subcategories that belong to the product.
  */
  public function subcats()
  {
    return $this->belongsToMany(SubCategory::class, 'category_product', 'product_id', 'subcat_id');
  }

  /**
   * Get the attributes for the product.
   */
  public function attrs()
  {
    return $this->hasMany(Attribute::class);
  }

  /**
   * Get the images for the product.
   */
  public function images()
  {
    return $this->hasMany(Image::class);
  }

  /**
   * Get the plus for the product.
   */
  public function plus()
  {
    return $this->hasMany(Plu::class);
  }

  /**
   * Get the reviews for the product.
   */
  public function reviews()
  {
    return $this->hasMany(Review::class);
  }
  
  /**
   * Get the wishlists for the product.
   */
  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }
}
?>