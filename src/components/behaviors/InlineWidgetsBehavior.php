<?php

namespace app\components\behaviors;

use CBehavior;
use CComponent;
use CController;
use Yii;

class InlineWidgetsBehavior extends CBehavior
{
    /**
     * @var string marker of block begin
     */
    public $startBlock = '[*';
    /**
     * @var string marker of block end
     */
    public $endBlock = '*]';
    /**
     * @var array of allowed widgets
     */
    public $widgets = [];

    protected $_widgetToken;

    public function __construct()
    {
        $this->initToken();
    }

    protected function initToken(): void
    {
        $this->_widgetToken = md5(microtime());
    }

    public function decodeWidgets(?string $text): string
    {
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_replaceBlocks($text);
        $text = $this->_processWidgets($text);
        return $text;
    }

    public function clearWidgets(?string $text): string
    {
        $text = $this->_clearAutoParagraphs($text);
        $text = $this->_replaceBlocks($text);
        $text = $this->_clearWidgets($text);
        return $text;
    }

    protected function _processWidgets(?string $text): string
    {
        if (preg_match('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', $text)) {
            foreach ($this->widgets as $alias => $class) {
                while (preg_match('#\{' . $this->_widgetToken . ':' . $alias . '(\|([^}]*)?)?' . $this->_widgetToken . '\}#is', $text, $p)) {
                    $text = str_replace($p[0], $this->_loadWidget($class, $p[2] ?? ''), $text);
                }
            }
            return $text;
        }
        return $text;
    }

    protected function _clearWidgets(?string $text): string
    {
        return preg_replace('|\{' . $this->_widgetToken . ':.+?' . $this->_widgetToken . '\}|is', '', $text);
    }

    protected function _replaceBlocks(?string $text): string
    {
        $text = str_replace($this->startBlock, '{' . $this->_widgetToken . ':', $text);
        $text = str_replace($this->endBlock, $this->_widgetToken . '}', $text);
        return $text;
    }

    protected function _clearAutoParagraphs(?string $output): string
    {
        $output = str_replace('<p>' . $this->startBlock, $this->startBlock, $output);
        $output = str_replace($this->endBlock . '</p>', $this->endBlock, $output);
        return $output;
    }

    protected function _loadWidget(string $widgetClass, string $attributes = ''): string
    {
        $attrs = $this->_parseAttributes($attributes);
        $cache = $this->_extractCacheExpireTime($attrs);

        $index = 'widget_' . $widgetClass . '_' . serialize($attrs);

        if ($cache && $cachedHtml = Yii::app()->cache->get($index)) {
            $html = $cachedHtml;
        } else {
            ob_start();
            $widget = Yii::app()->widgetFactory->createWidget($this->getController(), $widgetClass, $attrs);
            $widget->init();
            $widget->run();
            $html = trim(ob_get_clean());
            Yii::app()->cache->set($index, $html, $cache);
        }

        return $html;
    }

    protected function _parseAttributes(?string $attributesString): array
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

    protected function _extractCacheExpireTime(array &$attrs): int
    {
        $cache = 0;
        if (isset($attrs['cache'])) {
            $cache = (int)$attrs['cache'];
            unset($attrs['cache']);
        }
        return $cache;
    }

    /**
     * @return CController|CComponent
     */
    protected function getController(): CController
    {
        return $this->owner;
    }
}
