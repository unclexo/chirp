<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
}
