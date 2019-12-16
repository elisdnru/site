<?php

declare(strict_types=1);

namespace app\components\deworker\widgets;

use app\components\deworker\api\Api;
use yii\base\Widget;

class SeriesEpisodes extends Widget
{
    public string $slug;

    private Api $api;

    public function __construct(Api $api, $config = [])
    {
        parent::__construct($config);
        $this->api = $api;
    }

    public function run(): string
    {
        $series = $this->api->get('/edge/edu/series/' . $this->slug);

        $episodes = $series['episodes'] ?? [];

        return $this->render('series-episodes', [
            'slug' => $this->slug,
            'episodes' => $episodes,
        ]);
    }
}
