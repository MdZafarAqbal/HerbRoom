<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
  protected $fillable = ['id', 'name', 'capital', 'iso_code', 'lang', 'currency', 'currency_symbol', 'calling_code', 'tld', 'flag_icon', 'region', 'time_zone', 'date_format', 'status'];

  /**
   * Get the cities for the country.
   */
  public function cities()
  {
    return $this->hasMany(City::class);
  }

  /**
   * Get the states for the country.
   */
  public function states()
  {
    return $this->hasMany(State::class);
  }
}
