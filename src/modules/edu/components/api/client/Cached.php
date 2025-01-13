<?php

declare(strict_types=1);

namespace app\modules\edu\components\api\client;

use Laminas\Diactoros\Response\ArraySerializer;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;

final readonly class Cached implements ClientInterface
{
    private ClientInterface $next;
    private CacheInterface $cache;
    private int $ttl;

    public function __construct(ClientInterface $next, CacheInterface $cache, int $ttl)
    {
        $this->next = $next;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (!self::isCacheNeeded($request)) {
            return $this->next->sendRequest($request);
        }

        $key = self::cacheKey($request);

        /** @var array|null $cached */
        $cached = $this->cache->get($key);

        if ($cached !== null) {
            return ArraySerializer::fromArray($cached);
        }

        $result = $this->next->sendRequest($request);
        $this->cache->set($key, ArraySerializer::toArray($result), $this->ttl);
        $result->getBody()->rewind();

        return $result;
    }

    private static function isCacheNeeded(RequestInterface $request): bool
    {
        return \in_array($request->getMethod(), ['GET', 'HEAD', 'OPTIONS'], true);
    }

    private static function cacheKey(RequestInterface $request): string
    {
        return $request->getMethod() . $request->getUri();
    }
}
