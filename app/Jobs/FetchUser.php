<?php

namespace App\Jobs;

use App\Jobs\Traits\CallsTwitter;

class FetchUser extends BaseJob
{
    use CallsTwitter;

    public function handle() : void
    {
        $data = $this->checkForTwitterErrors(
            $this->twitter()->get('account/verify_credentials')
        );

        $data->settings = $this->checkForTwitterErrors(
            $this->twitter()->get('account/settings')
        );

        $this->user->update([
            'id'       => $data->id,
            'name'     => $data->name,
            'nickname' => $data->screen_name,
        ] + compact('data'));
    }
}
