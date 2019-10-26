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
        PortfolioAsset::register($this->view);

        $items = Work::find()
            ->published()
            ->orderBy(['sort' => SORT_DESC])
            ->limit($this->limit)
            ->all();

        return $this->render($this->tpl, [
            'items' => $items,
        ]);
    }
}
