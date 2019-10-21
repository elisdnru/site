<?php

namespace app\modules\search\widgets;

use app\modules\search\forms\SearchForm;
use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public $tpl = 'SearchForm';

    public function run(): string
    {
        $form = new SearchForm;

        if (isset($_REQUEST['q'])) {
            $form->q = $_REQUEST['q'];
        }

        return $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
