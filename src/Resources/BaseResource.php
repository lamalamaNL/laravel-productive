<?php

namespace LamaLama\Productive\Resources;

use LamaLama\Productive\ProductiveApiClient;

abstract class BaseResource
{
    /**
     * @var ProductiveApiClient
     */
    protected $client;

    /**
     * Indicates the type of resource.
     *
     * @example task
     *
     * @var string
     */
    public $resource;

    /**
     * @param  ProductiveApiClient  $client
     */
    public function __construct(ProductiveApiClient $client)
    {
        $this->client = $client;
    }
}
