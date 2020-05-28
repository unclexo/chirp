<?php

namespace App;

use App\Traits\Unguarded;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Unguarded;

    public $incrementing = false;

    protected $casts = [
        'data'      => 'object',
        'followers' => 'collection',
        'friends'   => 'collection',
        'muted'     => 'collection',
        'blocked'   => 'collection',
    ];

    public function diffs() : HasMany
    {
        return $this->hasMany(Diff::class);
    }

    public function favorites() : HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
