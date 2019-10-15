<?php

namespace app\components\widgets;

use app\modules\user\models\Access;
use CWidget;
use Yii;

class AdminBarWidget extends CWidget
{
    public $title = '';
    public $links = [];

    public function run(): void
    {
        if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
            $this->render('AdminBar', [
                'links' => $this->links
            ]);
        }
    }
}
