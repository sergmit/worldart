<?php
//ini_set('memory_limit','-1');
header('Content-Type: text/html; charset=utf-8');

use App\App;

require __DIR__.'/../vendor/autoload.php';

echo App::init();