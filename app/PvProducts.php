<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PvProducts extends Model
{
    public $table = "pv_products";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'pv_label', 'pv_quantite', 'pv_pu', 'pv_total'
    ];

    const UPDATED_AT = null;

    /**
    * Set the value of the "updated at" attribute.
    *
    * @param  mixed  $value
    * @return $this
    */
    public function setUpdatedAt($value)
    {
        return $this;
    }
}
