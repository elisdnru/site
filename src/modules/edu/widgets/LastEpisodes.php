<?php

declare(strict_types=1);

namespace app\modules\edu\widgets;

use app\modules\edu\components\api\Api;
use yii\base\Widget;

final class LastEpisodes extends Widget
{
    public int $limit = 6;
    private Api $api;

    public function __construct(Api $api, array $config = [])
    {
        parent::__construct($config);
        $this->api = $api;
    }

    public function run(): string
    {
        $episodes = $this->api->get('/edge/edu/last?limit=' . $this->limit);

        return $this->render('last-episodes', [
            'episodes' => $episodes,
        ]);
    }
}
