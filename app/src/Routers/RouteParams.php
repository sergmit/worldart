<?php

namespace App\Routers;

class RouteParams
{
    /**
     * @var string|null
     */
    protected $protocol;

    /**
     * @var string|null
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var QueryRoute
     */
    protected $query;

    /**
     * @var string|null
     */
    protected $fragment;

    /**
     * @return string|null
     */
    public function getProtocol(): ?string
    {
        return $this->protocol;
    }

    /**
     * @param string|null $protocol
     * @return RouteParams
     */
    public function setProtocol(?string $protocol): RouteParams
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @param string|null $host
     * @return RouteParams
     */
    public function setHost(string $host): RouteParams
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return RouteParams
     */
    public function setPath(string $path): RouteParams
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return QueryRoute
     */
    public function getQuery(): QueryRoute
    {
        return $this->query;
    }

    public function setQuery(QueryRoute $queryRoute)
    {
        $this->query = $queryRoute;

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setQueryParam(string $key, string $value): RouteParams
    {
        $this->query->set($key, $value);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

    /**
     * @param string|null $fragment
     * @return RouteParams
     */
    public function setFragment(string $fragment): RouteParams
    {
        $this->fragment = $fragment;

        return $this;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getLinkOrder(string $name)
    {
        $url = '';
        $this->query->setNextOrder($name);

        if (!empty($this->host)) {
            $url .= $this->host;
        }

        $url .= $this->getPath();

        $query = $this->query->getQueryNextOrder($name);

        if (strlen($query) > 1) {
            $url .= "?{$query}";
        }

        if (!empty($this->fragment)) {
            $url .= $this->fragment;
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        $url = '';

        if (!empty($this->host)) {
            $url .= $this->host;
        }

        $url .= $this->getPath();

        if (strlen($this->query) > 1) {
            $url .= "?{$this->query}";
        }

        if (!empty($this->fragment)) {
            $url .= $this->fragment;
        }

        return $url;
    }
}