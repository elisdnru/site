<?php

declare(strict_types=1);

namespace app\widgets;

use app\assets\AdminBarAsset;
use app\modules\user\models\Access;
use Override;
use yii\base\Widget;
use yii\web\User;

final class AdminBar extends Widget
{
    public array $links = [];

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

    #[Override]
    public function run(): string
    {
        if ($this->user->can(Access::CONTROL)) {
            AdminBarAsset::register($this->view);
            return $this->render('AdminBar', [
                'links' => $this->links,
            ]);
        }
        return '';
    }
}
