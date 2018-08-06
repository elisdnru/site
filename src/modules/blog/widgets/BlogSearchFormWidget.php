<?php

Yii::import('application.modules.blog.models.*');
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
