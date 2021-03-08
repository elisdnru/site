<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Portlet extends Widget
{
    public array $htmlOptions = ['class' => 'portlet'];
    public ?string $url = null;
    public ?string $title = null;
    public bool $hideOnEmpty = true;

    private string $openTag = '';

    public function init(): void
    {
        ob_start();
        echo Html::beginTag('div', $this->htmlOptions) . "\n";
        $this->renderDecoration();
        echo "<div class=\"portlet-content\">\n";
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
        $result .= Html::endTag('div');
        return $result;
    }

    private function renderDecoration(): void
    {
        if ($this->title !== null) {
            if ($this->url) {
                echo "<div class=\"portlet-title\"><a href=\"{$this->url}\">{$this->title}</a></div>\n";
            } else {
                echo "<div class=\"portlet-title\">{$this->title}</div>\n";
            }
        }
    }
}
