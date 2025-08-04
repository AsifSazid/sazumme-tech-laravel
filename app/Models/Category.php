<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SazUmme\Publication\Models\Ebook;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ebooks()
    {
        return $this->belongsToMany(Ebook::class, 'category_ebook');
    }
}
