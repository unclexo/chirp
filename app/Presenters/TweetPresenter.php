<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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

    public function media() : Collection
    {
        return ! empty($this->tweet->extended_entities)
            ? collect($this->tweet->extended_entities->media)
            : collect();
    }

    public function text() : string
    {
        return nl2br(
            $this->removeGalleryUrl(
                $this->renderLinks(
                    $this->renderHashtagsAndMentions(
                        $this->tweet->full_text
                    )
                )
            )
        );
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

    protected function renderHashtagsAndMentions(string $text) : string
    {
        $stringsToReplace    = [];
        $stringsReplacements = [];

        foreach ($this->tweet->entities->user_mentions as $mention) {
            $stringsToReplace[]    = mb_substr($text, $mention->indices[0], $mention->indices[1] - $mention->indices[0]);
            $stringsReplacements[] = '<a href="https://twitter.com/' . $mention->screen_name . '" target="_blank" rel="noopener" class="font-semibold hover:text-yellow-500">@' . $mention->screen_name . '</a>';
        }

        foreach ($this->tweet->entities->hashtags as $hashtag) {
            $stringsToReplace[]    = mb_substr($text, $hashtag->indices[0], $hashtag->indices[1] - $hashtag->indices[0]);
            $stringsReplacements[] = '<a href="https://twitter.com/hashtag/' . $hashtag->text . '" target="_blank" rel="noopener" class="font-semibold hover:text-yellow-500">#' . $hashtag->text . '</a>';
        }

        foreach ($stringsToReplace as $key => $stringToReplace) {
            $text = mb_ereg_replace($stringToReplace, $stringsReplacements[$key], $text);
        }

        return $text;
    }

    protected function renderLinks(string $text) : string
    {
        foreach ($this->tweet->entities->urls as $url) {
            $text = mb_ereg_replace($url->url, '<a href="' . $url->url . '" target="_blank" rel="noopener" class="font-semibold hover:text-yellow-500">' . $url->display_url . '</a>', $text);
        }

        return $text;
    }

    protected function removeGalleryUrl(string $text) : string
    {
        if (empty($this->tweet->extended_entities->media)) {
            return $text;
        }

        foreach ($this->tweet->extended_entities->media as $media) {
            $text = mb_ereg_replace($media->url, '', $text);
        }

        return $text;
    }
}
