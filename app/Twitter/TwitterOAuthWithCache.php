<?php

namespace App\Twitter;

use Illuminate\Support\Facades\Cache;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterOAuthWithCache extends TwitterOAuth
{
    public function get($path, array $parameters = [])
    {
        $key = md5($path . serialize($parameters));

        if (Cache::has($key)) {
            $this->response->setHttpCode(200);

            return Cache::get($key);
        }

        Cache::put($key, $response = parent::get($path, $parameters));

        return $response;
    }
}
