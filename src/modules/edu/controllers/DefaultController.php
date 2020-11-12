<?php

namespace app\modules\edu\controllers;

use yii\web\Controller;
use app\modules\edu\components\api\Api;

class DefaultController extends Controller
{
    private Api $api;

    public function __construct($id, $module, Api $api, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->api = $api;
    }

    public function actionIndex(): string
    {
        $series = $this->api->get('/edge/edu/series') ?? [];

        return $this->render('index', [
            'series' => $series,
        ]);
    }
}
