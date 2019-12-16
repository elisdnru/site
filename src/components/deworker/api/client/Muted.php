<?php

declare(strict_types=1);

namespace app\components\deworker\api\client;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use yii\web\ErrorHandler;

class Muted implements ClientInterface
{
    private ClientInterface $next;
    private ErrorHandler $handler;
    private ResponseFactoryInterface $factory;

    public function __construct(ClientInterface $next, ErrorHandler $handler, ResponseFactoryInterface $factory)
    {
        $this->next = $next;
        $this->handler = $handler;
        $this->factory = $factory;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->next->sendRequest($request);
        } catch (ClientExceptionInterface $exception) {
            $this->handler->logException($exception);
            return $this->factory->createResponse(503);
        }
    }
}
