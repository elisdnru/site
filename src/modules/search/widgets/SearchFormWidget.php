<?php

Yii::import('application.modules.search.models.*');

class SearchFormWidget extends DWidget
{
    public $tpl = 'SearchForm';

    public function run()
    {
        $form = new SearchForm;

        if (isset($_REQUEST['q'])){
            $form->q = $_REQUEST['q'];
        }

        $this->render($this->tpl ,array(
            'form'=>$form,
        ));
    }
}