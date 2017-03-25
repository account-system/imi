<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterType extends Model
{
    /**
     * Get the master type details belong to master type.
     */
    public function masterDetails()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all city records belong to cities table.
     */
    public function cities()
    {
        return $this->hasMany('App\MasterDetail');
    }
}
