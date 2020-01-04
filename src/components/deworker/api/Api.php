<?php

declare(strict_types=1);

namespace app\components\deworker\api;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

class Api
{
    private ClientInterface $client;
    private RequestFactoryInterface $factory;
    private string $url;

    public function __construct(ClientInterface $client, RequestFactoryInterface $factory, string $url)
    {
        $this->client = $client;
        $this->factory = $factory;
        $this->url = $url;
    }

    public function get(string $url): array
    {
        $request = $this->factory->createRequest('GET', $this->url . $url);
        $response = $this->client->sendRequest($request);
        $content = (string)$response->getBody();
        return $content ? json_decode($content, true, 512, JSON_THROW_ON_ERROR) : [];
    }
}
