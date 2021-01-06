<?php

namespace app\modules\edu\controllers;

use yii\base\Module;
use yii\web\Controller;
use app\modules\edu\components\api\Api;

class DefaultController extends Controller
{
    private Api $api;

    public function __construct(string $id, Module $module, Api $api, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->api = $api;
    }

    public function actionIndex(): string
    {
        $series = $this->api->get('/edge/edu/series');

        return $this->render('index', [
            'series' => $series,
        ]);
    }
}
