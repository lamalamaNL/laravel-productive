<?php

namespace LamaLama\Productive;


class Productive
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var ProductiveeApiClient
     */
    protected $client;

    public function __construct(ProductiveApiClient $client)
    {
        $this->client = $client;

        // $key = $this->config->get('productive.auth_token');

        if (! empty($key)) {
            $this->setAuthToken($key);
        }
    }
}
