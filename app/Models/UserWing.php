<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWing extends Model
{
    use HasFactory;

    protected $table = 'user_wings'; 
    protected $guarded = [];    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wing()
    {
        return $this->belongsTo(Wing::class);
    }
}
