<?php

namespace App;

use App\Traits\Unguarded;
use Illuminate\Database\Eloquent\Model;

class Diff extends Model
{
    use Unguarded;

    protected $casts = [
        'additions' => 'collection',
        'deletions' => 'collection',
    ];
}
