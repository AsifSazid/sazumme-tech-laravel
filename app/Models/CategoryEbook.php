<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryEbook extends Model
{
    use SoftDeletes;

    protected $table = 'category_ebook';

    protected $guarded = [];
}

