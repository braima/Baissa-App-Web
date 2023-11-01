<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeanceServices extends Model
{
    public $table = "seanceservices";
    protected $primaryKey = 'id';

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
