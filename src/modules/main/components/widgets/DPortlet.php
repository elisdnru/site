<?php

Yii::import('zii.widgets.CPortlet');

class DPortlet extends CPortlet
{
    public $url = '';

    public function getId($autoGenerate=true)
    {
        return null;
    }

    /**
     * Renders the decoration for the portlet.
     * The default implementation will render the title if it is set.
     */
    protected function renderDecoration()
    {
        if($this->title!==null)
        {
            echo "<div class=\"{$this->decorationCssClass}\">\n";
            if ($this->url)
                echo "<div class=\"{$this->titleCssClass}\"><span><a href=\"{$this->url}\">{$this->title}</a></span></div>\n";
            else
                echo "<div class=\"{$this->titleCssClass}\"><span>{$this->title}</span></div>\n";
            echo "</div>\n";
        }
    }
}
