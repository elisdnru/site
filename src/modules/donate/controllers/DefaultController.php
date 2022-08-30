<?php

declare(strict_types=1);

namespace app\modules\donate\controllers;

use yii\web\Controller;
use yii\web\Response;

final class DefaultController extends Controller
{
    public function actionIndex(): Response
    {
        return $this->redirect('https://products.elisdn.ru/order/donate/', 302);
    }
}
