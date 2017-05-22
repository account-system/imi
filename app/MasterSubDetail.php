<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterSubDetail extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'master_type_id',
    ];

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
