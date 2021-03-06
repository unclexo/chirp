<?php

namespace App\Twitter;

use Illuminate\Support\Facades\Cache;
use Abraham\TwitterOAuth\TwitterOAuth;

// This is used for testing only.
class TwitterOAuthWithCache extends TwitterOAuth
{
    public function get($path, array $parameters = [])
    {
        $key = "{$path}_" . md5(serialize($parameters));

        if (Cache::has($key)) {
            $this->response->setHttpCode(200);

            return Cache::get($key);
        }

        $response = parent::get($path, $parameters);

        // If we get an error (likely "rate limit exceeded"), we don't cache the response.
        if (empty($response->errors)) {
            Cache::put($key, $response);
        }

        return $response;
    }
}
