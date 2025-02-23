<?php

declare(strict_types=1);

namespace app\modules\home\controllers;

use Override;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * @psalm-api
 */
final class ErrorController extends Controller
{
    #[Override]
    public function actions(): array
    {
        return [
            'index' => [
                'class' => ErrorAction::class,
            ],
        ];
    }
}
