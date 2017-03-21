<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_by', 'updated_by', 'created_at', 'updated_at',
    ];

    /**
     * Get the master type that owns the master type detail.
     */
    public function vendorlist()
    {
        return $this->belongsTo('App\Vendorlist');
    }
}
