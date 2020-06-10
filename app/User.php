<?php

namespace App;

use App\Traits\Unguarded;
use App\Presenters\UserPresenter;
use Illuminate\Support\Collection;
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

    public function getFollowersAttribute() : Collection
    {
        return new Collection(json_decode($this->attributes['followers']) ?? []);
    }

    public function getFriendsAttribute() : Collection
    {
        return new Collection(json_decode($this->attributes['friends']) ?? []);
    }

    public function getMutedAttribute() : Collection
    {
        return new Collection(json_decode($this->attributes['muted']) ?? []);
    }

    public function getBlockedAttribute() : Collection
    {
        return new Collection(json_decode($this->attributes['blocked']) ?? []);
    }

    public function getPresenterAttribute() : UserPresenter
    {
        return new UserPresenter($this->data);
    }
}
