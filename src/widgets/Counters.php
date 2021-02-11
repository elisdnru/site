<?php

declare(strict_types=1);

namespace app\widgets;

use app\modules\user\models\Access;
use yii\base\Widget;
use yii\web\User;

class Counters extends Widget
{
    private User $user;

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    /**
     * @psalm-suppress TypeDoesNotContainType
     */
    public function run(): string
    {
        if (YII_DEBUG || $this->user->can(Access::ROLE_ADMIN)) {
            return '';
        }

        return $this->render('Counters');
    }
}
