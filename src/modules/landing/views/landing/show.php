<?php

use app\components\InlineWidgetsBehavior;
use app\modules\landing\models\Landing;
use yii\web\View;

/**
 * @var View|InlineWidgetsBehavior $this
 * @var $landing Landing
 */

echo $this->decodeWidgets($landing->text);
