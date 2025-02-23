<?php

declare(strict_types=1);

namespace app\components;

use DateInterval;
use DateTimeImmutable;
use Override;
use Psr\SimpleCache\CacheInterface;
use yii\caching\CacheInterface as YiiCacheInterface;

final readonly class SimpleCacheAdapter implements CacheInterface
{
    private YiiCacheInterface $cache;

    /**
     * @psalm-api
     */
    public function __construct(YiiCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    #[Override]
    public function get(string $key, mixed $default = null): mixed
    {
        /** @var false|mixed $result */
        $result = $this->cache->get($key);
        return $result !== false ? $result : $default;
    }

    #[Override]
    public function set(string $key, mixed $value, null|DateInterval|int $ttl = null): bool
    {
        return $this->cache->set($key, $value, self::toSeconds($ttl));
    }

    #[Override]
    public function delete(string $key): bool
    {
        return $this->cache->delete($key);
    }

    #[Override]
    public function clear(): bool
    {
        return $this->cache->flush();
    }

    #[Override]
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $strings = [];
        foreach ($keys as $key) {
            $strings[] = $key;
        }

        /**
         * @var iterable<string, mixed>
         */
        return $this->cache->multiGet($strings);
    }

    #[Override]
    public function setMultiple(iterable $values, null|DateInterval|int $ttl = null): bool
    {
        /**
         * @var array<string, mixed> $items
         */
        $items = [];
        /**
         * @var string $key
         * @var mixed $value
         */
        foreach ($values as $key => $value) {
            /** @psalm-suppress MixedAssignment */
            $items[$key] = $value;
        }

        return $this->cache->multiSet($items, self::toSeconds($ttl)) !== [];
    }

    #[Override]
    public function deleteMultiple(iterable $keys): bool
    {
        $res = true;
        foreach ($keys as $key) {
            $res = $this->cache->delete($key) || $res;
        }
        return $res;
    }

    #[Override]
    public function has(string $key): bool
    {
        return $this->cache->exists($key);
    }

    private static function toSeconds(null|DateInterval|int $ttl): int
    {
        if ($ttl instanceof DateInterval) {
            return (new DateTimeImmutable('@0'))->add($ttl)->getTimestamp();
        }

        return $ttl ?: 0;
    }
}
