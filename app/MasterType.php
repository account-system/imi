<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterType extends Model
{
	/**
     * Get all customer type records belong to customer type table.
     */
    public function customerTypeRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all employee type records belong to employee type table.
     */
    public function employeeTypeRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
    * Get all doctor type records belong to doctor type table.
    */
    public function doctorTypeRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all supplier type records belong to supplier type table.
     */
    public function supplierTypeRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all category records belong to category table.
     */
    public function categoryRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all branch records belong to branch table.
     */
    public function branchRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }
    
    /**
     * Get all country records belong to country table.
     */
    public function countryRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all city records belong to city table.
     */
    public function cityRecords()
    {
        return $this->hasMany('App\MasterSubDetail');
    }

    /**
     * Get all measure records belong to measure table.
     */
    public function measureRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }

    /**
     * Get all item type records belong to item type table.
     */
    public function itemTypeRecords()
    {
        return $this->hasMany('App\MasterDetail');
    }
}
