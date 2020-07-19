<?php

namespace app\modules\edu\controllers;

use app\components\Controller;
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
        $items = array_reverse($this->api->get('/edge/edu/last?limit=12') ?? []);

        return $this->render('index', [
            'series' => $series,
            'items' => $items,
        ]);
    }
}
