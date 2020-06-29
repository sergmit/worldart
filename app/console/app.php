<?php

use App\Database\DB;

require __DIR__ . '/../vendor/autoload.php';

DB::init();

$commandList = include __DIR__ . '/commands.php';

$inp_command = $argv[1];
unset($argv[0], $argv[1]);

if (isset($commandList[$inp_command])) {
    $commandClass = $commandList[$inp_command];
    $command = new $commandClass();
    $args = null;

    if (!empty($argv)) {
        $args = [];

        foreach (array_values($argv) as $item) {
            if (preg_match('/^--([^=]+)=?(.*)/', $item, $match)) {
                $args[$match[1]] = $match[2];
            }
        }
    }

    $command->execute($args);
} else {
    echo "Command $inp_command not found" . PHP_EOL;
}