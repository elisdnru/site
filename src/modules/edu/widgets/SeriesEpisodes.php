<?php

declare(strict_types=1);

namespace app\modules\edu\widgets;

use app\modules\edu\components\api\Api;
use Override;
use yii\base\Widget;

final class SeriesEpisodes extends Widget
{
    public string $slug = '';

    private Api $api;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(Api $api, array $config = [])
    {
        parent::__construct($config);
        $this->api = $api;
    }

    #[Override]
    public function run(): string
    {
        /**
         * @psalm-var array{episodes: array} $series
         */
        $series = $this->api->get('/edge/edu/series/' . $this->slug);

        $episodes = $series['episodes'];

        return $this->render('series-episodes', [
            'slug' => $this->slug,
            'episodes' => $episodes,
        ]);
    }
}
