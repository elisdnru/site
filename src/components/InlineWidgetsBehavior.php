<?php

declare(strict_types=1);

namespace app\components;

use Exception;
use yii\base\Behavior;
use yii\base\Widget;
use yii\caching\CacheInterface;

final class InlineWidgetsBehavior extends Behavior
{
    public string $startBlock = '[{widget:';
    public string $endBlock = '}]';
    /**
     * @var string[]
     * @psalm-var array<string, class-string<Widget>>
     */
    public array $widgets = [];

    private CacheInterface $cache;
    private string $widgetToken;

    public function __construct(CacheInterface $cache, array $config = [])
    {
        parent::__construct($config);
        $this->cache = $cache;
        $this->widgetToken = md5(microtime());
    }

    public function decodeWidgets(?string $text): string
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
        $text = str_replace($this->startBlock, '{' . $this->widgetToken . ':', $text);
        return str_replace($this->endBlock, $this->widgetToken . '}', $text);
    }

    private function clearAutoParagraphs(string $output): string
    {
        $output = str_replace('<p>' . $this->startBlock, $this->startBlock, $output);
        return str_replace($this->endBlock . '</p>', $this->endBlock, $output);
    }

    /**
     * @psalm-param class-string<Widget> $widgetClass
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
