<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SazUmme\Publication\Models\Ebook;

class EbookPage extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function ebook()
    {
        return $this->belongsTo(Ebook::class);
    }
}
