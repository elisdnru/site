<?php

declare(strict_types=1);

namespace app\modules\edu\widgets;

use app\modules\edu\components\api\Api;
use yii\base\Widget;

final class FreeEpisodes extends Widget
{
    public int $limit = 5;
    private Api $api;

    public function __construct(Api $api, array $config = [])
    {
        parent::__construct($config);
        $this->api = $api;
    }

    public function run(): string
    {
        $episodes = $this->api->get('/edge/edu/free?limit=' . $this->limit);

        return $this->render('free-episodes', [
            'episodes' => $episodes,
        ]);
    }
}
