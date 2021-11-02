<?php

declare(strict_types=1);

namespace app\components;

use yii\base\Widget;
use yii\caching\CacheInterface;

final class WidgetShortcodes
{
    private const START_BLOCK = '[{widget:';
    private const END_BLOCK = '}]';

    /**
     * @var array<string, class-string<Widget>>
     */
    private array $widgets;
    private CacheInterface $cache;

    /**
     * @param array<string, class-string<Widget>> $widgets
     */
    public function __construct(array $widgets, CacheInterface $cache)
    {
        $this->widgets = $widgets;
        $this->cache = $cache;
    }

    public function process(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        $token = md5(microtime());
        $result = $this->trimParagraphs($text);
        $result = $this->replaceBlocks($result, $token);
        return $this->processWidgets($result, $token);
    }

    private function trimParagraphs(string $text): string
    {
        return strtr($text, [
            '<p>' . self::START_BLOCK => self::START_BLOCK,
            self::END_BLOCK . '</p>' => self::END_BLOCK,
        ]);
    }

    private function replaceBlocks(string $text, string $token): string
    {
        return strtr($text, [
            self::START_BLOCK => '{' . $token . ':',
            self::END_BLOCK => $token . '}',
        ]);
    }

    private function processWidgets(string $text, string $token): string
    {
        if (preg_match('|\{' . $token . ':.+?' . $token . '\}|is', $text)) {
            foreach ($this->widgets as $alias => $class) {
                $pattern = '#\{' . $token . ':' . $alias . '(\|([^}]*)?)?' . $token . '\}#is';
                while (preg_match($pattern, $text, $p)) {
                    $text = str_replace($p[0], $this->loadWidget($class, $p[2] ?? ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    /**
     * @param class-string<Widget> $widgetClass
     */
    private function loadWidget(string $widgetClass, string $attributes = ''): string
    {
        $attrs = $this->parseAttributes($attributes);
        $cache = $this->extractCacheExpireTime($attrs);

        $index = 'widget_' . $widgetClass . '_' . json_encode($attrs, JSON_THROW_ON_ERROR);

        if ($cache && $cachedHtml = (string)$this->cache->get($index)) {
            $html = $cachedHtml;
        } else {
            ob_start();
            echo $widgetClass::widget($attrs);
            $html = trim(ob_get_clean());
            $this->cache->set($index, $html, $cache);
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

    private function extractCacheExpireTime(array &$attrs): int
    {
        $cache = 0;
        /** @var array{cache?: string} $attrs */
        if (isset($attrs['cache'])) {
            $cache = (int)$attrs['cache'];
            unset($attrs['cache']);
        }
        return $cache;
    }
}
