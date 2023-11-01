<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commandes extends Model
{
    public $table = "commandes";
    protected $primaryKey = 'id';

    // protected static $logAttributes = ['id', 'status', 'livrer'];

    // protected static $logName = 'Commande';

    // public function getDescriptionForEvent(string $eventName): string
    // {
    //     return "You have {$eventName} Product";
    // }

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
