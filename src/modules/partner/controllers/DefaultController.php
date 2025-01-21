<?php

declare(strict_types=1);

namespace app\modules\partner\controllers;

use app\modules\partner\model\ItemsFetcher;
use yii\web\Controller;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
{
    public function actionIndex(ItemsFetcher $items): string
    {
        $items = $items->getAll();

        return $this->render('index', [
            'items' => $items,
        ]);
    }
}
