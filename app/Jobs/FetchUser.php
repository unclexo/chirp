<?php

namespace App\Jobs;

use App\Facades\Twitter;
use App\Jobs\Traits\CallsTwitter;

class FetchUser extends BaseJob
{
    use CallsTwitter;

    public function fire() : void
    {
        $data = $this->guardAgainstTwitterErrors(
            Twitter::get('account/verify_credentials')
        );

        $data->settings = $this->guardAgainstTwitterErrors(
            Twitter::get('account/settings')
        );

        $this->user->fill([
            'id'       => $data->id,
            'name'     => $data->name,
            'nickname' => $data->screen_name,
            'data'     => $data,
        ])->save();
    }
}
