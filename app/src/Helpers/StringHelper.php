<?php

namespace App\Helpers;

use App\Routers\QueryRoute;
use App\Routers\RouteParams;

class StringHelper
{
    /**
     * @param string $str
     * @return RouteParams
     */
    public static function parseUri(string $str): RouteParams
    {
        $dataUrl = parse_url($str);

        $route = new RouteParams();
        $route->setPath($dataUrl['path']);

        if (!empty($dataUrl['protocol'])) {
            $route->setProtocol($dataUrl['protocol']);
        }

        $route->setQuery(new QueryRoute($dataUrl['query'] ?? ''));

        if (!empty($dataUrl['fragment'])) {
            $route->setFragment($dataUrl['fragment']);
        }

        return $route;
    }

    /**
     * @param string $str
     * @return false|string|null
     */
    public static function toUtf8(string $str)
    {
        return iconv('windows-1251', 'utf-8', $str);
    }
}