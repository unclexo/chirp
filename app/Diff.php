<?php

namespace App;

use App\Traits\Unguarded;
use App\Presenters\DiffPresenter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Diff extends Model
{
    use Unguarded;

    protected $casts = [
        'additions' => 'collection',
        'deletions' => 'collection',
    ];

    public static function diffsHistory(int $user_id, string $for) : Collection
    {
        $diffs = DB::table('diffs')
            ->selectRaw('
                DATE(created_at) AS date,
                user_id,
                JSON_ARRAYAGG(additions) AS additions,
                JSON_ARRAYAGG(deletions) AS deletions
            ')
            ->where('user_id', $user_id)
            ->where('for', $for)
            ->groupBy('date')
            ->groupBy('user_id')
            ->orderBy('date', 'DESC')
            ->get();

        return $diffs->map(fn ($d) => new DiffPresenter($d));
    }
}
