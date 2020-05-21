<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diff extends Model
{
    protected $guarded = [];

    protected $casts = [
        'additions' => 'collection',
        'deletions' => 'collection',
    ];
}
