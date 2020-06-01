<?php

namespace App\Presenters;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class DiffPresenter
{
    protected object $diff;

    public function __construct(object $diff)
    {
        $this->diff = $diff;
    }

    public function date() : string
    {
        return Carbon::parse($this->diff->date)->isoFormat('LL');
    }

    public function additions() : array
    {
        return Arr::collapse(json_decode($this->diff->additions, true));
    }

    public function deletions() : array
    {
        return Arr::collapse(json_decode($this->diff->deletions, true));
    }
}
