<?php

namespace app\components\widgets;

use CPortlet;
use Yii;

Yii::import('zii.widgets.CPortlet');

class Portlet extends CPortlet
{
    public $url = '';

    public function getId($autoGenerate = true): ?string
    {
        return null;
    }

    protected function renderDecoration(): void
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
