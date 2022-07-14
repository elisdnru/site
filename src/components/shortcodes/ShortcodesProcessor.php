<?php

declare(strict_types=1);

namespace app\components\shortcodes;

use yii\caching\CacheInterface;

use function strtr;

final class ShortcodesProcessor
{
    private const START_BLOCK = '[{widget:';
    private const END_BLOCK = '}]';

    /**
     * @var array<string, string>
     */
    private array $widgets;
    private WidgetRenderer $renderer;
    private CacheInterface $cache;

    /**
     * @param array<string, string> $widgets
     */
    public function __construct(array $widgets, WidgetRenderer $renderer, CacheInterface $cache)
    {
        $this->widgets = $widgets;
        $this->renderer = $renderer;
        $this->cache = $cache;
    }

    public function process(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        return $this->processWidgets($this->trimParagraphs($text));
    }

    private function trimParagraphs(string $text): string
    {
        return strtr($text, [
            '<p>' . self::START_BLOCK => self::START_BLOCK,
            self::END_BLOCK . '</p>' => self::END_BLOCK,
        ]);
    }

    private function processWidgets(string $text): string
    {
        if (!str_contains($text, self::START_BLOCK)) {
            return $text;
        }

        $result = $text;
        foreach ($this->widgets as $slug => $class) {
            $pattern = '#' . preg_quote(self::START_BLOCK, '|') . $slug . '(\|(.*))?' . preg_quote(self::END_BLOCK, '#') . '#sU';

            while (preg_match($pattern, $result, $p)) {
                $attributes = $this->parseAttributes($p[2] ?? '');
                $result = str_replace($p[0], $this->renderWidget($class, $attributes), $result);
            }
        }

        return $result;
    }

    private function renderWidget(string $class, array $attributes): string
    {
        [$cacheDuration, $restAttributes] = $this->extractCacheDuration($attributes);
        $cacheKey = $this->generateCacheKey($class, $restAttributes);

        if ($cacheDuration && $cachedHtml = (string)$this->cache->get($cacheKey)) {
            return $cachedHtml;
        }

        $html = $this->renderer->render($class, $restAttributes);

        if ($cacheDuration) {
            $this->cache->set($cacheKey, $html, $cacheDuration);
        }

        return $html;
    }

    private function parseAttributes(string $attributesString): array
    {
        $params = explode(';', $attributesString);
        $attrs = [];

        foreach ($params as $param) {
            if ($param) {
                [$attribute, $value] = explode('=', $param);
                if ($value) {
                    $attrs[$attribute] = trim($value);
                }
            }
        }

        ksort($attrs);
        return $attrs;
    }

    /**
     * @return array{int, array}
     */
    private function extractCacheDuration(array $attributes): array
    {
        $cache = 0;
        /** @var array{cache?: string} $attributes */
        if (isset($attributes['cache'])) {
            $cache = (int)$attributes['cache'];
        }
        return [$cache, array_diff_key($attributes, ['cache' => 0])];
    }

    private function generateCacheKey(string $class, array $attributes): string
    {
        return 'widget_' . $class . '_' . json_encode($attributes, JSON_THROW_ON_ERROR);
    }
}
