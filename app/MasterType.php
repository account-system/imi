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
}
