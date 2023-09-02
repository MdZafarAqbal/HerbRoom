<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelItem extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_id', 'attr_id', 'quantity', 'discount', 'total', 'reason'];
  
  /**
   * Get the attribute that owns the cancel item.
   */
  public function attr()
  {
    return $this->belongsTo(Attribute::class, 'attr_id');
  }

  /**
   * Get the order that owns the cancel item.
   */
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}
