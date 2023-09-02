<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'method' => 'op',
    'status' => 'unpaid'
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['order_id', 'account_name', 'account_no', 'charge', 'method', 'subtotal', 'tax', 'shipping', 'discount', 'cancelled', 'returned', 'total', 'refund', 'status'];
  
  /**
   * Get the order that owns the payment.
   */
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
}
