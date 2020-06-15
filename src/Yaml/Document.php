<?php

namespace Nova\Yaml;

use Illuminate\Support\Arr;

class Document
{
    protected $matter;
    protected $body;

    public function __construct($matter, $body)
    {
        $this->matter = is_array($matter) ? $matter : [];
        $this->body = $body;
    }

    public function matter( $key = null, $default = null)
    {
        if ($key) {
            return Arr::get($this->matter, $key, $default);
        }

        return $this->matter;
    }

    public function body()
    {
        return $this->body;
    }

    public function __get($key)
    {
        return $this->matter($key);
    }
}
