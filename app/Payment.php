<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'payments';

    /**
     * Get all of the owning payable models.
     */
    public function payable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
