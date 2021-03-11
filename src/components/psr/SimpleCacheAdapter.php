<?php

declare(strict_types=1);

namespace app\components\psr;

use DateInterval;
use DateTimeImmutable;
use Psr\SimpleCache\CacheInterface;
use yii\caching\CacheInterface as YiiCacheInterface;

class SimpleCacheAdapter implements CacheInterface
{
    private YiiCacheInterface $cache;

    public function __construct(YiiCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function get($key, $default = null)
    {
        /** @var mixed|false $result */
        $result = $this->cache->get($key);
        return $result !== false ? $result : $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        return $this->cache->set($key, $value, self::toSeconds($ttl));
    }

    public function delete($key): bool
    {
        return $this->cache->delete($key);
    }

    public function clear(): bool
    {
        return $this->cache->flush();
    }

    public function getMultiple($keys, $default = null): array
    {
        /** @var string[] $keys */
        return $this->cache->multiGet($keys);
    }

    public function setMultiple($values, $ttl = null): bool
    {
        return $this->cache->multiSet((array)$values, self::toSeconds($ttl)) !== [];
    }

    public function deleteMultiple($keys): bool
    {
        $res = true;
        /** @var string $key */
        foreach ($keys as $key) {
            $res = $res || $this->cache->delete($key);
        }
        return $res;
    }

    public function has($key): bool
    {
        return $this->cache->exists($key);
    }

    private static function toSeconds(null|int|DateInterval $ttl): int
    {
        if ($ttl instanceof DateInterval) {
            return (new DateTimeImmutable('@0'))->add($ttl)->getTimestamp();
        }

        return $ttl ?: 0;
    }
}
