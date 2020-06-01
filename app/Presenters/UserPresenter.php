<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;

class UserPresenter
{
    public object $data;

    public function __construct(object $data)
    {
        $this->data = $data;
    }

    public function avatar(bool $full = false) : string
    {
        return $full
            ? str_replace('_normal', '', $this->data->profile_image_url_https)
            : $this->data->profile_image_url_https;
    }

    public function date() : string
    {
        return Carbon::parse($this->data->created_at)->isoFormat('LL');
    }

    public function description() : string
    {
        return $this->render('description');
    }

    public function websiteDisplayUrl() : ?string
    {
        return optional(optional(optional(optional($this->data->entities)->url)->urls)[0])->display_url;
    }

    public function websiteUrl() : ?string
    {
        return optional(optional(optional(optional($this->data->entities)->url)->urls)[0])->url;
    }

    protected function render(string $key) : string
    {
        $text = $this->data->{$key};

        foreach ($this->data->entities->$key->urls as $url) {
            $text = mb_ereg_replace($url->url, '<a href="' . $url->url . '" target="_blank" rel="noopener" class="font-semibold hover:text-yellow-500">' . $url->display_url . '</a>', $text);
        }

        return $text;
    }

    public function __call($name, $arguments)
    {
        if (preg_match('/Count$/', $name)) {
            $property = str_replace('Count', '', $name);
            $property = $property . '_count';

            return number_format($this->data->$property);
        }
    }
}
