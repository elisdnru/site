<?php

declare(strict_types=1);

namespace yii\web;

use yii\base\Component;
use yii\base\Module;
use yii\base\ViewContextInterface;

class Controller extends Component implements ViewContextInterface
{
    /**
     * @var Module|null
     */
    public ?Module $module = null;

    public function getViewPath(): string
    {
        return '';
    }
}
