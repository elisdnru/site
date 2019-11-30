<?php

namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class BreadcrumbsWidget extends Widget
{
    public $tagName = 'div';
    public $htmlOptions = ['class' => 'breadcrumbs'];
    public $links = [];
    public $activeLinkTemplate = '<a href="{url}">{label}</a>';
    public $inactiveLinkTemplate = '<!--noindex--><span>{label}</span><!--/noindex-->';
    public $separator = ' &raquo; ';

    public function run(): string
    {
        if (empty($this->links)) {
            return '';
        }

        $html = Html::beginTag($this->tagName, $this->htmlOptions) . "\n";
        $links = [];
        $definedLinks = ['Дмитрий Елисеев' => Yii::$app->homeUrl] + $this->links;
        foreach ($definedLinks as $label => $url) {
            if (is_string($label) || is_array($url)) {
                $links[] = strtr($this->activeLinkTemplate, [
                    '{url}' => Url::to($url),
                    '{label}' => Html::encode($label),
                ]);
            } else {
                $links[] = str_replace('{label}', Html::encode($url), $this->inactiveLinkTemplate);
            }
        }
        $html .= implode($this->separator, $links);
        $html .= Html::endTag($this->tagName);
        return $html;
    }
}
