<?php

namespace app\components\widgets;

use Yii;
use yii\base\Behavior;
use yii\base\Widget;

class InlineWidgetsBehavior extends Behavior
{
    /**
     * @var string marker of block begin
     */
    public $startBlock = '[{widget:';
    /**
     * @var string marker of block end
     */
    public $endBlock = '}]';
    /**
     * @var array of allowed widgets
     */
    public $widgets = [];

    private $widgetToken;

    public function init(): void
    {
        $this->widgetToken = md5(microtime());
    }

    public function decodeWidgets(?string $text): string
    {
        $text = $this->clearAutoParagraphs($text);
        $text = $this->replaceBlocks($text);
        $text = $this->processWidgets($text);
        return $text;
    }

    public function clearWidgets(?string $text): string
    {
        $text = $this->clearAutoParagraphs($text);
        $text = $this->replaceBlocks($text);
        $text = $this->clearAllWidgets($text);
        return $text;
    }

    private function processWidgets(?string $text): string
    {
        if (preg_match('|\{' . $this->widgetToken . ':.+?' . $this->widgetToken . '\}|is', $text)) {
            foreach ($this->widgets as $alias => $class) {
                while (preg_match('#\{' . $this->widgetToken . ':' . $alias . '(\|([^}]*)?)?' . $this->widgetToken . '\}#is', $text, $p)) {
                    $text = str_replace($p[0], $this->loadWidget($class, $p[2] ?? ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    private function clearAllWidgets(?string $text): string
    {
        return preg_replace('|\{' . $this->widgetToken . ':.+?' . $this->widgetToken . '\}|is', '', $text);
    }

    private function replaceBlocks(?string $text): string
    {
        $text = str_replace($this->startBlock, '{' . $this->widgetToken . ':', $text);
        $text = str_replace($this->endBlock, $this->widgetToken . '}', $text);
        return $text;
    }

    private function clearAutoParagraphs(?string $output): string
    {
        $output = str_replace('<p>' . $this->startBlock, $this->startBlock, $output);
        $output = str_replace($this->endBlock . '</p>', $this->endBlock, $output);
        return $output;
    }

    private function loadWidget(string $widgetClass, string $attributes = ''): string
    {
        $attrs = $this->parseAttributes($attributes);
        $cache = $this->extractCacheExpireTime($attrs);

        $index = 'widget_' . $widgetClass . '_' . serialize($attrs);

        if ($cache && $cachedHtml = Yii::$app->cache->get($index)) {
            $html = $cachedHtml;
        } else {
            ob_start();
            /** @var Widget $widgetClass */
            echo $widgetClass::widget($attrs);
            $html = trim(ob_get_clean());
            Yii::$app->cache->set($index, $html, $cache);
        }

        return $html;
    }

    private function parseAttributes(?string $attributesString): array
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
        if (isset($attrs['cache'])) {
            $cache = (int)$attrs['cache'];
            unset($attrs['cache']);
        }
        return $cache;
    }
}
