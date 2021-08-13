<?php

declare(strict_types=1);

namespace app\widgets;

use yii\base\Widget;
use yii\web\Session;

final class Messages extends Widget
{
    private Session $session;

    public function __construct(Session $session, array $config = [])
    {
        parent::__construct($config);
        $this->session = $session;
    }

    public function run(): string
    {
        return $this->render('Messages', [
            'session' => $this->session,
        ]);
    }
}
