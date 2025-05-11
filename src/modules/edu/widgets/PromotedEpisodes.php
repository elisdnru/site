<?php

declare(strict_types=1);

namespace app\modules\edu\widgets;

use app\modules\edu\components\api\Api;
use Override;
use yii\base\Widget;

final class PromotedEpisodes extends Widget
{
    public int $limit = 6;
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
        $episodes = $this->api->get('/edge/edu/promoted?limit=' . $this->limit);

        return $this->render('promoted-episodes', [
            'episodes' => $episodes,
        ]);
    }
}
