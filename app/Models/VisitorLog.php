<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'visit_date',
        'country',
        'browser',
        'device',
        'visit_from'
    ];
}
