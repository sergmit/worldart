<?php


namespace App\Services;


use App\Models\Category;
use App\Routers\QueryRoute;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MovieService
{
    protected static $instance;
    /**
     * @var CacheService
     */
    protected $cacheService;

    protected function __construct()
    {
        $this->cacheService = CacheService::getInstance();
    }

    /**
     * @return MovieService
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * @param QueryRoute $queryParams
     * @return iterable
     */
    public function getMovies(QueryRoute $queryParams): iterable
    {
        $orderBy = $queryParams->getOrders();
        $orderField = empty($orderBy) ? 'position' : key($orderBy);
        $orderValue = empty($orderBy) ? 'asc' : $orderBy[$orderField];
        $created = $queryParams->get('created');
        $created = empty($created) ? date('Y-m-d') : $created;

        return $this->cacheService
            ->get("categories:order:$orderField:$orderValue:created:$created:", function () use ($orderField, $orderValue, $created) {
                $query = Category::with(['ratingMovies' =>
                    function (HasManyThrough $query) use ($orderField, $orderValue, $created) {
                        $query->with(['movie' => function ($query) use ($orderField, $orderValue) {

                        }]);

                        if (in_array($orderField, ['position', 'score', 'voices', 'averageScore'])) {
                            $query->orderBy($orderField, $orderValue);
                        }
                        if (in_array($orderField, ['name', 'year'])) {
                            $query->orderBy("movie.$orderField", $orderValue);
                        }

                        if (!empty($created)) {
                            $query->where('created', $created);
                        }
                    }]);
                return $query->get();
            });
    }
}