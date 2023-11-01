<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Activitylog\Traits\LogsActivity;

class Categories extends Model
{
    //use LogsActivity;

    public $table = "category";
    protected $primaryKey = 'id';

    // protected static $logAttributes = ['id_category', 'ordre', 'frontname', 'frontorder'];

    // protected static $logName = 'Categories';

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
