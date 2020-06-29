<?php

namespace App\Redis;

use Predis\Client as RedisClient;

class Client
{
    protected static $instance;

    protected function __construct()
    {
    }

    /**
     * @return RedisClient
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            $config = include __DIR__ . '/../config/redis.php';
            self::$instance = new RedisClient([
                'host' => $config['host'],
                'password' => $config['password'],
                'port' => $config['port']
            ]);
        }

        return self::$instance;
    }
}