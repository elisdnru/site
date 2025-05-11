<?php

declare(strict_types=1);

namespace app\widgets;

use app\modules\user\models\Access;
use Override;
use yii\base\Widget;
use yii\web\User;

final class Counters extends Widget
{
    private User $user;

    /**
     * @psalm-api
     * @param array<string, mixed> $config
     */
    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    /**
     * @psalm-suppress TypeDoesNotContainType
     */
    #[Override]
    public function run(): string
    {
        if (YII_DEBUG || $this->user->can(Access::ROLE_ADMIN)) {
            return '';
        }

        return $this->render('Counters');
    }
}
