<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seancesHistory extends Model
{
    //use LogsActivity;

    public $table = "seanceshistory";
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
