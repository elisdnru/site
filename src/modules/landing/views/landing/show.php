<?php

declare(strict_types=1);

use app\components\shortcodes\Shortcodes;
use app\modules\landing\models\Landing;
use yii\web\View;

/**
 * @var View $this
 * @var Landing $landing
 */
Shortcodes::begin(); ?><?= $landing->text; ?><?php Shortcodes::end(); ?>
