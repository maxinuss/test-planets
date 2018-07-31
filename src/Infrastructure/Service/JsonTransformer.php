<?php
declare(strict_types=1);

namespace Planet\Infrastructure\Service;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class JsonTransformer
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param $item
     * @param $transformer
     * @return array
     */
    public function formatItem($item, TransformerAbstract $transformer)
    {
        $resource = new Item($item, $transformer);

        return $this->manager->createData($resource)->toArray()['data'];
    }

    /**
     * @param $collection
     * @param $transformer
     * @return array
     */
    public function formatCollection($collection, TransformerAbstract $transformer)
    {
        $resource = new Collection($collection, $transformer);

        return $this->manager->createData($resource)->toArray()['data'];
    }
}
