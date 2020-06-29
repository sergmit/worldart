<?php

namespace App\Services;

use Goutte\Client;

abstract class AbstractHtmlParser
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

}