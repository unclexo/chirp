<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    protected $casts = [
        'data' => 'object',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
