<?php

namespace App\Presenters;

abstract class BasePresenter
{
    protected $resource;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function __get($key)
    {
        if (! empty($this->resource->$key)) {
            return $this->resource->$key;
        }

        if (! empty($this->resource->data) && ! empty($this->resource->data->$key)) {
            return $this->resource->data->$key;
        }
    }
}
