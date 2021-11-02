<?php

declare(strict_types=1);

namespace app\components;

use Exception;
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
    private string $widgetToken;

    /**
     * @param array<string, class-string<Widget>> $widgets
     */
    public function __construct(CacheInterface $cache, array $widgets)
    {
        $this->cache = $cache;
        $this->widgets = $widgets;
        $this->widgetToken = md5(microtime());
    }

    public function process(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        $result = $this->clearAutoParagraphs($text);
        $result = $this->replaceBlocks($result);
        return $this->processWidgets($result);
    }

    private function processWidgets(string $text): string
    {
        if (preg_match('|\{' . $this->widgetToken . ':.+?' . $this->widgetToken . '\}|is', $text)) {
            foreach ($this->widgets as $alias => $class) {
                $pattern = '#\{' . $this->widgetToken . ':' . $alias . '(\|([^}]*)?)?' . $this->widgetToken . '\}#is';
                while (preg_match($pattern, $text, $p)) {
                    $text = str_replace($p[0], $this->loadWidget($class, $p[2] ?? ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    private function replaceBlocks(string $text): string
    {
        $text = str_replace(self::START_BLOCK, '{' . $this->widgetToken . ':', $text);
        return str_replace(self::END_BLOCK, $this->widgetToken . '}', $text);
    }

    private function clearAutoParagraphs(string $output): string
    {
        $output = str_replace('<p>' . self::START_BLOCK, self::START_BLOCK, $output);
        return str_replace(self::END_BLOCK . '</p>', self::END_BLOCK, $output);
    }

    /**
     * @param class-string<Widget> $widgetClass
     * @throws Exception
     */
    private function loadWidget(string $widgetClass, string $attributes = ''): string
    {
        $attrs = $this->parseAttributes($attributes);
        $cache = $this->extractCacheExpireTime($attrs);

        $index = 'widget_' . $widgetClass . '_' . serialize($attrs);

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
