<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
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
  protected $fillable = ['name', 'slug', 'status'];

  /**
   * The products that belong to the form.
  */
  public function products()
  {
    return $this->belongsToMany(Product::class);
  }

  /**
   * Get the attributes for the form.
   */
  public function attrs()
  {
    return $this->hasMany(Attribute::class);
  }

  /**
   * Get the plus for the form.
   */
  public function plus()
  {
    return $this->hasMany(Plu::class);
  }
}  
