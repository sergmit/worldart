<?php


namespace App\Services;



use App\Redis\Client;

class CacheService
{
    protected static $instance;

    /**
     * @var Client
     */
    protected $client;

    protected function __construct()
    {
        $this->client = Client::getInstance();
    }

    /**
     * @return CacheService
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param $key
     * @param callable|null $func
     * @return iterable|null
     */
    public function get($key, ?callable $func = null): ?iterable
    {
        if($this->client->exists($key)) {
            return unserialize($this->client->get($key));
        } else {
            $data = $func();
            if (!empty($data)) {
                $this->client->set($key, serialize($func()));
            } else {
                return null;
            }
        }

        return $this->get($key);
    }

    /**
     * @return Client|\Predis\Client
     */
    public function redis(): \Predis\Client
    {
        return $this->client;
    }

}