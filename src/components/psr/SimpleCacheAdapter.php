<?php

declare(strict_types=1);

namespace app\components\psr;

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
        $result = $this->cache->get($key);
        return $result !== false ? $result : $default;
    }

    public function set($key, $value, $ttl = null): bool
    {
        return $this->cache->set($key, $value, $ttl);
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
        return $this->cache->multiGet((array)$keys);
    }

    public function setMultiple($values, $ttl = null): bool
    {
        return [] !== $this->cache->multiSet((array)$values, $ttl);
    }

    public function deleteMultiple($keys): bool
    {
        $res = true;
        foreach ($keys as $key) {
            $res = $res || $this->cache->delete($key);
        }
        return $res;
    }

    public function has($key): bool
    {
        return $this->cache->exists($key);
    }
}
