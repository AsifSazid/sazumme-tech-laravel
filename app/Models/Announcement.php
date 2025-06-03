<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function wing()
    {
        return $this->belongsTo(Wing::class, 'announcement_for');
    }
}
