<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB
{
    public static function init(): void
    {
        $config = include __DIR__ . '/../config/db.php';

        $capsule = new Capsule;
        $capsule->addConnection([
            "driver" => $config['driver'],
            "host" => $config['host'],
            "database" => $config['dbname'],
            "username" => $config['user'],
            "password" => $config['password'],
            "charset" => 'utf8'
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
        $capsule->getConnection()->enableQueryLog();
    }

    /**
     * @return array
     */
    public static function getQueryLog(): array
    {
        return Capsule::connection()->getQueryLog();
    }
}