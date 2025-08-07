<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableHistory extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'table_name',
        'target_id',
        'target_name',
        'action',
        'item_name',
        'before_update',
        'after_update',
        'responder',
        'compatible_date',
    ];
}
