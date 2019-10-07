<?php

namespace app\modules\blog\widgets;

use app\components\module\UrlRulesHelper;
use app\modules\blog\forms\BlogSearchForm;
use app\components\widgets\Widget;

UrlRulesHelper::import('blog');

class BlogSearchFormWidget extends Widget
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
