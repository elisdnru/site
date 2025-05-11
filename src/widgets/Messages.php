<?php

declare(strict_types=1);

namespace app\widgets;

use Override;
use yii\base\Widget;
use yii\web\Session;

final class Messages extends Widget
{
    private Session $session;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(Session $session, array $config = [])
    {
        parent::__construct($config);
        $this->session = $session;
    }

    #[Override]
    public function run(): string
    {
        return $this->render('Messages', [
            'session' => $this->session,
        ]);
    }
}
