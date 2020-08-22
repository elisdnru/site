<?php

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use Yii;
use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public string $tpl = 'SearchForm';

    public function run(): string
    {
        $form = new SearchForm();

        $form->load(Yii::$app->request->queryParams);

        return $this->render($this->tpl, [
            'form' => $form,
        ]);
    }
}
