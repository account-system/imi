<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_of_birth', 'start_work','end_work','start_contract', 'end_contract'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'start_work' => 'date',
        'end_work' => 'date',
        'start_contract' => 'date',
        'end_contract' => 'date'
    ];
    
}
