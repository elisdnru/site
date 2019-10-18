<?php

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use CWidget;

class SearchFormWidget extends CWidget
{
    public $tpl = 'SearchForm';

    public function run(): void
    {
        $form = new SearchForm;

        if (isset($_REQUEST['word'])) {
            $form->word = $_REQUEST['word'];
        }

        $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
