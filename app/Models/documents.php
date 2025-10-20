<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documents extends Model
{
    protected $fillable = ['title', 'file_path', 'file_type', 'document_category'];
}
