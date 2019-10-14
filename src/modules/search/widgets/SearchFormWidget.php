<?php

namespace app\modules\search\widgets;

use app\components\widgets\Widget;
use app\modules\search\forms\SearchForm;

class SearchFormWidget extends Widget
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
