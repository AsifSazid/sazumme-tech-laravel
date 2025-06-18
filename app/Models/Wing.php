<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Wing extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function navigations()
    {
        return $this->hasMany(Announcement::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
