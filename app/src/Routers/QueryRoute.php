<?php


namespace App\Routers;


class QueryRoute
{
    protected $params = [];
    protected $orders = [];
    protected $nextOrder = [];

    /**
     * QueryRoute constructor.
     * @param string $query
     */
    public function __construct(string $query)
    {
        $data = explode('&', $query);

        if (!empty($data)) {
            foreach ($data as $item) {
                if (empty($item)) {
                    continue;
                }

                $param = explode('=', $item);
                $this->params[$param[0]] = $param[1];
            }
        }
        $this->setOrdering();
    }

    /**
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public function get(string $key, ?string $default = null): ?string
    {
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }

        return $default;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function set(string $key, string $value): QueryRoute
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!empty($this->params) || !empty($this->orders)) {
            $data = [];

            foreach ($this->params as $key => $value) {
                $data[] = "$key=$value";
            }

            foreach ($this->orders as $key => $value) {
                $data[] = "order:$key=$value";
            }

            return implode('&', $data);
        }

        return '';
    }

    /**
     * @param string $name
     */
    public function setNextOrder(string $name)
    {
        $nextOrder = null;

        if (!isset($this->orders[$name])) {
            $this->nextOrder[$name] = 'asc';
        } else if ($this->orders[$name] === 'desc') {
            $this->nextOrder[$name] = 'asc';
        } else if ($this->orders[$name] === 'asc') {
            $this->nextOrder[$name] = 'desc';
        }
    }

    /**
     * @param string $name
     * @return string
     */
    public function getQueryNextOrder(string $name)
    {
        if (!empty($this->params) || !empty($this->nextOrder[$name])) {

            $data = [];

            foreach ($this->params as $key => $value) {
                $data[] = "$key=$value";
            }

            $data[] = "order:$name=" . $this->nextOrder[$name];

            return implode('&', $data);
        }

        return '';
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @param string $name
     * @return string|null
     */
    public function getOrder(string $name): ?string
    {
        if (isset($this->orders[$name])) {
            return $this->orders[$name];
        } else {
            return null;
        }
    }

    protected function setOrdering()
    {
        foreach ($this->params as $name => $item) {
            $data = explode(':', $name);
            if ($data[0] === 'order') {
                $this->orders[$data[1]] = $item;
                unset($this->params[$name]);
            }
        }
    }
}