<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  use MassPrunable;

  /**
   * Get the prunable model query.
   */
  public function prunable(): Builder
  {
    return static::where('created_at', '<=', now()->subMonth());
  }
}