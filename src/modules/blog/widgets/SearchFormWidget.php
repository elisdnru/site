<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use BadMethodCallException;
use Yii;
use yii\base\Widget;
use yii\web\Request;

final class SearchFormWidget extends Widget
{
    public function run(): string
    {
        $form = new SearchForm();

        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        $form->load($request->getQueryParams());

        return $this->render('SearchForm', [
            'form' => $form,
        ]);
    }
}
