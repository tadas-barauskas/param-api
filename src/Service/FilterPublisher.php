<?php

namespace App\Service;

use Predis\Client;

class FilterPublisher
{
    /**
     * @var FilterCollector
     */
    private $collector;
    /**
     * @var Client
     */
    private $client;

    public function __construct(FilterCollector $collector, Client $client)
    {
        $this->collector = $collector;
        $this->client = $client;
    }

    public function refresh(): void
    {
        foreach ($this->collector->collect() as $key => $filterSet) {
            $this->client->set($key, json_encode($filterSet));
        }
    }
}
