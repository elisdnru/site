<?php

use app\components\InlineWidgetsBehavior;
use app\modules\landing\models\Landing;
use yii\web\View;

/**
 * @var View|InlineWidgetsBehavior $this
 * @psalm-var View&InlineWidgetsBehavior $this
 * @var Landing $landing
 */

echo $this->decodeWidgets($landing->text);
