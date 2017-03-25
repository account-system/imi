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
     * Get the master type that owns the master type detail.
     */
    public function masterType()
    {
        return $this->belongsTo('App\MasterType');
    }
}
