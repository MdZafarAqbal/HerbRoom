<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
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
  protected $fillable = ['name', 'product_id', 'status'];
  
  /**
   * Get the product that owns the image.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
