<?php

namespace App\Traits;

trait Unguarded
{
    public function initializeUnguarded() : void
    {
        $this->guarded = [];

        self::$unguarded = true;
    }
}
