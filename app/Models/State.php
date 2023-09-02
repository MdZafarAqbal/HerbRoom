<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
  /**
   * Indicates if the model's ID is auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  /**
   * The model's default values for attributes.
   *
   * @var array
   */
  protected $attributes = [
    'status' => 'inactive'
  ];
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['id', 'name', 'country_id', 'status'];

  /**
   * Get the country that owns the state.
   */
  public function country()
  {
    return $this->belongsTo(Country::class);
  }
  
  /**
   * Get the cities for the state.
   */
  public function cities()
  {
    return $this->hasMany(City::class);
  }
}
