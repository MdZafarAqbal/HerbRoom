<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedBanner extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name', 'photo_mobile', 'photo_tablet', 'photo_desktop'];
}
