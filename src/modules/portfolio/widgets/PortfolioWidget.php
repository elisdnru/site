<?php

namespace app\modules\portfolio\widgets;

use app\modules\portfolio\Module;
use CDbCriteria;
use app\components\widgets\Widget;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;

class PortfolioWidget extends Widget
{
    public $tpl = 'Portfolio';
    public $class = '';
    public $limit = 4;

    public function run(): void
    {
        Module::registerScripts();

        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'sort DESC';

        $items = Work::model()->published()->cache(0, new Tags('portfolio'))->findAll($criteria);

        $this->render($this->tpl, [
            'items' => $items,
        ]);
    }
}
