<?php

namespace app\widgets;

use app\assets\AdminBarAsset;
use app\modules\user\models\Access;
use yii\base\Widget;
use yii\web\User;

class AdminBar extends Widget
{
    public string $title = '';
    public array $links = [];

    private User $user;

    public function __construct(User $user, array $config = [])
    {
        parent::__construct($config);
        $this->user = $user;
    }

    public function run(): string
    {
        if ($this->user->can(Access::CONTROL)) {
            AdminBarAsset::register($this->view);
            return $this->render('AdminBar', [
                'links' => $this->links
            ]);
        }
        return '';
    }
}
