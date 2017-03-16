<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ]; 

    /**
     * Set the customer type's generate id.
     *
     * @param  string  $value
     * @return void
     */
    public function setGenerateIdAttribute()
    {
        $this->attributes['generate_id'] = $this->attributes['id'];
    }	
}
