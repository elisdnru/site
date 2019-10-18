<?php

namespace app\modules\search\widgets;

use app\modules\search\forms\SearchForm;
use CWidget;

class SearchFormWidget extends CWidget
{
    public $tpl = 'SearchForm';

    public function run(): void
    {
        $form = new SearchForm;

        if (isset($_REQUEST['q'])) {
            $form->q = $_REQUEST['q'];
        }

        $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
