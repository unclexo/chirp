<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blocked extends Model
{
    protected $casts = [
        'data' => 'object',
    ];

    protected $table = 'blocked';

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
