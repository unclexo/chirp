<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class UserPresenter extends BasePresenter
{
    public function avatar() : string
    {
        return $this->profile_image_url_https;
    }

    public function date() : string
    {
        return Carbon::parse($this->created_at)->isoFormat('LL');
    }

    public function description() : string
    {
        return $this->render('description');
    }

    public function websiteDisplayUrl() : string
    {
        return $this->entities->url->urls[0]->display_url;
    }

    public function websiteUrl() : string
    {
        return $this->entities->url->urls[0]->url;
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/Count$/', $name)) {
            $property = str_replace('Count', '', $name);
            $property = $property . '_count';

            return number_format($this->$property);
        }
    }

    protected function render(string $key) : string
    {
        $text = $this->{$key};

        foreach ($this->entities->$key->urls as $url) {
            $text = mb_ereg_replace($url->url, '<a href="' . $url->url . '" target="_blank" rel="noopener" class="font-semibold hover:text-yellow-500">' . $url->display_url . '</a>', $text);
        }

        return $text;
    }
}
