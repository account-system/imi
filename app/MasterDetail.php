<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterDetail extends Model
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
     * Get the customer type table that owns the customer type record.
     */
    public function customerTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the employee type table that owns the employee type record.
     */
    public function employeeTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the doctor type table that owns the doctor type record.
     */
    public function doctorTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the supplier type table that owns the supplier type record.
     */
    public function supplierTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the product table that owns the product record.
     */
    public function productTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the branch table that owns the branch record.
     */
    public function branchTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the county table that owns the county record.
     */
    public function countyTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get all city records belong to country record.
     */
    public function cityRecords()
    {
        return $this->hasMany('App\MasterSubDetail');
    }
}
