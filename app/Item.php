<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_type_id', 'name', 'code_barcode', 'qr_code', 'lot_number', 'sku', 'expire_date', 'image', 'category_id', 'measure_id', 'discontinue', 'on_hand', 'as_of_date', 'reorder_point', 'sale_description', 'price', 'income_account_id', 'purchase_description', 'cost', 'expense_account_id','branch_id', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
       'discontinue' => 'boolean' 
    ];
}
