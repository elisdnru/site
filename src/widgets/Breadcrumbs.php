<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Breadcrumbs extends Widget
{
    public string $tagName = 'div';
    public array $htmlOptions = ['class' => 'breadcrumbs'];
    public array $links = [];
    public string $activeLinkTemplate = '<a href="{url}">{label}</a>';
    public string $inactiveLinkTemplate = '<!--noindex--><span>{label}</span><!--/noindex-->';
    public string $separator = ' &raquo; ';

    public function run(): string
    {
        if ($this->links === []) {
            return '';
        }

        $html = Html::beginTag($this->tagName, $this->htmlOptions) . "\n";
        $links = [];
        $definedLinks = ['Дмитрий Елисеев' => ['/home/default/index']] + $this->links;
        /**
         * @var string|int $label
         * @var string|array $url
         */
        foreach ($definedLinks as $label => $url) {
            if (is_string($label)) {
                $links[] = strtr($this->activeLinkTemplate, [
                    '{url}' => Url::to($url),
                    '{label}' => Html::encode($label),
                ]);
            } elseif (is_string($url)) {
                $links[] = str_replace('{label}', Html::encode($url), $this->inactiveLinkTemplate);
            }
        }
        $html .= implode($this->separator, $links);
        $html .= Html::endTag($this->tagName);
        return $html;
    }
}
