<?php

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use app\components\widgets\Widget;

class SearchFormWidget extends Widget
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
