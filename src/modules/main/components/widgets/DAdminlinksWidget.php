<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

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
