<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Portlet extends Widget
{
    public $url = '';

    public $tagName = 'div';
    public $htmlOptions = ['class' => 'portlet'];
    public $title;
    public $decorationCssClass = 'portlet-decoration';
    public $titleCssClass = 'portlet-title';
    public $contentCssClass = 'portlet-content';
    public $hideOnEmpty = true;

    private $openTag;

    public function init(): void
    {
        ob_start();
        ob_implicit_flush(false);

        echo Html::beginTag($this->tagName, $this->htmlOptions) . "\n";
        $this->renderDecoration();
        echo "<div class=\"{$this->contentCssClass}\">\n";

        $this->openTag = ob_get_contents();
        ob_clean();
    }

    public function run(): string
    {
        $content = ob_get_clean();
        if ($this->hideOnEmpty && trim($content) === '') {
            return '';
        }
        $result = $this->openTag;
        $result .= $content;
        $result .= "</div>\n";
        $result .= Html::endTag($this->tagName);
        return $result;
    }

    private function renderDecoration(): void
    {
        if ($this->title !== null) {
            echo "<div class=\"{$this->decorationCssClass}\">\n";
            if ($this->url) {
                echo "<div class=\"{$this->titleCssClass}\"><span><a href=\"{$this->url}\">{$this->title}</a></span></div>\n";
            } else {
                echo "<div class=\"{$this->titleCssClass}\"><span>{$this->title}</span></div>\n";
            }
            echo "</div>\n";
        }
    }
}
