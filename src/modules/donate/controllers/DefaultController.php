<?php

declare(strict_types=1);

namespace app\modules\donate\controllers;

use yii\web\Controller;
use yii\web\Response;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
{
    public function actionIndex(): Response
    {
        return $this->redirect('https://spasibomir.ru/pay/29288', 302);
    }
}
