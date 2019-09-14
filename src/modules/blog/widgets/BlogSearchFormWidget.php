<?php

namespace app\modules\blog\widgets;

use app\components\module\DUrlRulesHelper;
use BlogSearchForm;
use DWidget;

DUrlRulesHelper::import('blog');

class BlogSearchFormWidget extends DWidget
{
    public $tpl = 'BlogSearchForm';

    public function run()
    {
        $form = new BlogSearchForm;

        if (isset($_REQUEST['word'])) {
            $form->word = $_REQUEST['word'];
        }

        $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
