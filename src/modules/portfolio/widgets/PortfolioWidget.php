<?php

namespace app\modules\portfolio\widgets;

use app\assets\PortfolioAsset;
use CDbCriteria;
use app\modules\portfolio\models\Work;
use app\extensions\cachetagging\Tags;
use Yii;
use yii\base\Widget;

class PortfolioWidget extends Widget
{
    public $tpl = 'Portfolio';
    public $class = '';
    public $limit = 4;

    public function run(): string
    {
        PortfolioAsset::register(Yii::$app->view);

        $criteria = new CDbCriteria;
        $criteria->limit = $this->limit;
        $criteria->order = 'sort DESC';

        $items = Work::model()->published()->cache(0, new Tags('portfolio'))->findAll($criteria);

        return $this->render($this->tpl, [
            'items' => $items,
        ]);
    }
}
