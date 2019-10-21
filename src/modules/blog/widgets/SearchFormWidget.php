<?php

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public $tpl = 'SearchForm';

    public function run(): string
    {
        $form = new SearchForm;

        if (isset($_REQUEST['word'])) {
            $form->word = $_REQUEST['word'];
        }

        return $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
