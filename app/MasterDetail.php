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
        'master_type_id', 'created_by', 'updated_by', 'created_at', 'updated_at',
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
     * Get the vendor type table that owns the vendor type record.
     */
    public function vendorTypeTable()
    {
        return $this->belongsTo('App\MasterType');
    }

    /**
     * Get the category table that owns the category record.
     */
    public function categoryTypeTable()
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
