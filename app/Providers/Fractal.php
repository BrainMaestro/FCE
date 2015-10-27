<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/17/2015
 * Time: 2:38 PM
 */

namespace Fce\Providers;


use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Illuminate\Pagination\AbstractPaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class Fractal
{
    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    public function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);

        return $rootScope;
    }

    public function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);
        $rootScope = $this->fractal->createData($resource);

        return $rootScope;
    }

    public function respondWithPaginatedCollection(AbstractPaginator $paginator, $callback)
    {
        $resource = new Collection($paginator->getCollection(), $callback);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        $rootScope = $this->fractal->createData($resource);

        return $rootScope;
    }
}