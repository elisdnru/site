<?php

declare(strict_types=1);

namespace app\modules\portfolio\widgets;

use app\assets\PortfolioAsset;
use app\modules\portfolio\models\Work;
use yii\base\Widget;

class PortfolioWidget extends Widget
{
    public int $limit = 4;

    public function run(): string
    {
        PortfolioAsset::register($this->view);

        $items = Work::find()
            ->published()
            ->orderBy(['sort' => SORT_DESC])
            ->limit($this->limit)
            ->all();

        return $this->render('Portfolio', [
            'items' => $items,
        ]);
    }
}
