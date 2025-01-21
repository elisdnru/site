<?php

declare(strict_types=1);

namespace app\modules\edu\controllers;

use app\modules\edu\components\api\Api;
use yii\base\Module;
use yii\web\Controller;

/**
 * @psalm-api
 */
final class DefaultController extends Controller
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
        $episodes = $this->api->get('/edge/edu/last?limit=9');

        return $this->render('index', [
            'series' => $series,
            'episodes' => $episodes,
        ]);
    }
}
