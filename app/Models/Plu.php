<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plu extends Model
{
  /**
   * Indicates if the model's ID is auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id', 'product_id', 'form_id'];

  /**
   * Get the form that owns the plu.
   */
  public function form()
  {
    return $this->belongsTo(Form::class);
  }

  /**
   * Get the product that owns the plu.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
