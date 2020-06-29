<?php

namespace Console\Commands;

use App\Services\CacheService;
use App\Services\HtmlParser;
use Console\BaseCommand;

class Cache extends BaseCommand
{
    /**
     * @var HtmlParser
     */
    protected $htmlParser;

    public function __construct()
    {
        $this->htmlParser = new HtmlParser();
    }

    /**
     * @param array|null $args
     */
    public function execute(array $args = null)
    {
        if(isset($args['clear'])) {
            CacheService::getInstance()->redis()->flushall();
        }
    }
}

;