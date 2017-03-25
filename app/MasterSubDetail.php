<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSubDetail extends Model
{
    /**
     * Get the city table that owns the city record.
     */
    public function cityTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the country record that owns the city record.
     */
    public function countryRecord()
    {
        return $this->belongsTo('App\MasterDetail');
    }
}
