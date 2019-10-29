<?php

namespace app\modules\portfolio\components;

use app\assets\PortfolioAsset;
use app\components\Controller;
use Yii;

abstract class PortfolioBaseController extends Controller
{
    public function beforeAction($action): bool
    {
        PortfolioAsset::register(Yii::$app->view);

        return parent::beforeAction($action);
    }
}
