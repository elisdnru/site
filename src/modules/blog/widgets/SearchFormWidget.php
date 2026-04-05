<?php

declare(strict_types=1);

namespace app\modules\blog\widgets;

use app\modules\blog\forms\SearchForm;
use BadMethodCallException;
use Override;
use Webmozart\Assert\Assert;
use Yii;
use yii\base\Widget;
use yii\web\Application;
use yii\web\Request;

final class SearchFormWidget extends Widget
{
    #[Override]
    public function run(): string
    {
        $form = new SearchForm();

        $request = Assert::isInstanceOf(Yii::$app, Application::class)->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        $form->load($request->getQueryParams());

        return $this->render('SearchForm', [
            'form' => $form,
        ]);
    }
}
