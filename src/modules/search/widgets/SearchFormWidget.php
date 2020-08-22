<?php

namespace app\modules\search\widgets;

use app\modules\search\forms\SearchForm;
use Yii;
use yii\base\Widget;

class SearchFormWidget extends Widget
{
    public function run(): string
    {
        $form = new SearchForm();

        $form->load(Yii::$app->request->queryParams);

        return $this->render('SearchForm', [
            'form' => $form,
        ]);
    }
}
