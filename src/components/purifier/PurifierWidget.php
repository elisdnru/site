<?php

declare(strict_types=1);

namespace app\components\purifier;

use Override;
use yii\base\Widget;

final class PurifierWidget extends Widget
{
    public bool $encodePreContent = false;
    public array $purifierOptions = [
        'Attr.AllowedRel' => ['nofollow'],
    ];

    private Purifier $purifier;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(Purifier $purifier, array $config = [])
    {
        parent::__construct($config);
        $this->purifier = $purifier;
    }

    #[Override]
    public function init(): void
    {
        parent::init();
        ob_start();
    }

    #[Override]
    public function run(): string
    {
        $text = trim(ob_get_clean());
        return $this->purifier->purify($text, $this->purifierOptions, $this->encodePreContent);
    }
}
