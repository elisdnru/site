<?php

use app\components\module\DUrlRulesHelper;
use app\modules\user\models\Access;

DUrlRulesHelper::import('admin');

class DAdminlinksWidget extends CWidget
{

    public $title = '';
    public $links = [];
    public $info = '';

    public function run()
    {
        if (Yii::app()->user->checkAccess(Access::ROLE_CONTROL)) {
            $this->render('Adminlinks', [
                'links' => $this->links,
                'info' => $this->info
            ]);
        }
    }
}
