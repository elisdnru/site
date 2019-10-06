<?php

namespace app\components\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\user\models\Access;
use CWidget;
use Yii;

UrlRulesHelper::import('admin');

class AdminLinksWidget extends CWidget
{
    public $title = '';
    public $links = [];

    public function run()
    {
        if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
            $this->render('Adminlinks', [
                'links' => $this->links
            ]);
        }
    }
}
