<?php

declare(strict_types=1);

namespace app\modules\partner\controllers;

use app\modules\partner\model\ItemsFetcher;
use yii\base\Module;
use yii\web\Controller;

final class DefaultController extends Controller
{
    private ItemsFetcher $items;

    public function __construct(string $id, Module $module, ItemsFetcher $items, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->items = $items;
    }

    public function actionIndex(): string
    {
        $items = $this->items->getAll();

        return $this->render('index', [
            'items' => $items,
        ]);
    }
}
