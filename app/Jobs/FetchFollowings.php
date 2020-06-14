<?php

namespace App\Jobs;

use App\Jobs\Traits\MakesDiffs;

class FetchFollowings extends BaseJob
{
    use MakesDiffs;

    public function fire() : void
    {
        $this->makeDiffFor('friends');
    }
}
