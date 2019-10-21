<?php

namespace app\components\widgets;

use yii\base\Widget;

class BreadcrumbsWidget extends Widget
{
    public $links = [];

    public function run(): string
    {
        return $this->render('BreadCrumbs', ['links' => $this->links]);
    }
}
