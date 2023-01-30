<?php

namespace LamaLama\Productive\Resources;

use LamaLama\Productive\ProductiveApiClient;

abstract class CursorCollection extends BaseCollection
{
    /**
     * @var ProductiveApiClient
     */
    protected $client;

    /**
     * @param ProductiveApiClient $client
     * @param int $count
     * @param \stdClass|null $_links
     */
    final public function __construct(ProductiveApiClient $client, $count, $_links)
    {
        parent::__construct($count, $_links);

        $this->client = $client;
    }

    /**
     * @return BaseResource
     */
    abstract protected function createResourceObject();

    /**
     * Return the next set of resources when available
     *
     * @return CursorCollection|null
     * @throws \LamaLama\Productive\Exceptions\ApiException
     */
    final public function next()
    {
        if (! $this->hasNext()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(ProductiveApiClient::HTTP_GET, $this->_links->next->href);

        $collection = new static($this->client, $result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * Return the previous set of resources when available
     *
     * @return CursorCollection|null
     * @throws \LamaLama\Productive\Exceptions\ApiException
     */
    final public function previous()
    {
        if (! $this->hasPrevious()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(ProductiveApiClient::HTTP_GET, $this->_links->previous->href);

        $collection = new static($this->client, $result->count, $result->_links);

        foreach ($result->_embedded->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * Determine whether the collection has a next page available.
     *
     * @return bool
     */
    public function hasNext()
    {
        return isset($this->_links->next->href);
    }

    /**
     * Determine whether the collection has a previous page available.
     *
     * @return bool
     */
    public function hasPrevious()
    {
        return isset($this->_links->previous->href);
    }
}
