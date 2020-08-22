<?php

namespace app\widgets;

use app\assets\AdminBarAsset;
use app\modules\user\models\Access;
use Yii;
use yii\base\Widget;

class AdminBar extends Widget
{
    public string $title = '';
    public array $links = [];

    public function run(): string
    {
        if (Yii::$app->user->can(Access::CONTROL)) {
            AdminBarAsset::register($this->view);
            return $this->render('AdminBar', [
                'links' => $this->links
            ]);
        }
        return '';
    }
}
