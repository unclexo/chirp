<?php

namespace App\Jobs;

use App\Jobs\Traits\MakesDiffs;

class FetchFollowers extends BaseJob
{
    use MakesDiffs;

    public function handle() : void
    {
        $this->makeDiffFor('followers');
    }
}
