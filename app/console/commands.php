<?php

use Console\Commands\Parse;
use Console\Commands\Migration;
use Console\Commands\Cache;

return [
    'parse' => Parse::class,
    'migration' => Migration::class,
    'cache' => Cache::class
];