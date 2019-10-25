<?php

namespace app\components\widgets;

use app\modules\user\models\Access;
use Yii;
use yii\base\Widget;

class AdminBarWidget extends Widget
{
    public $title = '';
    public $links = [];

    public function run(): string
    {
        if (Yii::app()->user->checkAccess(Access::CONTROL)) {
            return $this->render('AdminBar', [
                'links' => $this->links
            ]);
        }
        return '';
    }
}
