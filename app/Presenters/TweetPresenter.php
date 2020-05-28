<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class TweetPresenter
{
    protected object $tweet;

    public function __construct(object $tweet)
    {
        $this->tweet = $tweet;
    }

    public function avatar() : string
    {
        return $this->user->profile_image_url_https;
    }

    public function date() : string
    {
        return Carbon::parse($this->created_at)->isoFormat('LL');
    }

    public function text() : string
    {
        $text = $this->tweet->full_text;

        $stringsToReplace    = [];
        $stringsReplacements = [];

        foreach ($this->tweet->entities->user_mentions as $mention) {
            $stringsToReplace[]    = mb_substr($text, $mention->indices[0], $mention->indices[1] - $mention->indices[0]);
            $stringsReplacements[] = '<a href="https://twitter.com/' . $mention->screen_name . '" target="_blank" rel="noopener" class="font-semibold hover:text-white">@' . $mention->screen_name . '</a>';
        }

        foreach ($stringsToReplace as $key => $stringToReplace) {
            $text = mb_ereg_replace($stringToReplace, $stringsReplacements[$key], $text);
        }

        foreach ($this->tweet->entities->urls as $url) {
            $text = str_replace($url->url, '<a href="' . $url->url . '" target="_blank" rel="noopener" class="font-semibold hover:text-white">' . $url->display_url . '</a>', $text);
        }

        return nl2br($text);
    }

    public function url() : string
    {
        return "https://twitter.com/{$this->user->screen_name}/status/{$this->id}";
    }

    public function userUrl() : string
    {
        return "https://twitter.com/{$this->user->screen_name}";
    }

    public function __get($key)
    {
        return $this->tweet->$key;
    }
}
