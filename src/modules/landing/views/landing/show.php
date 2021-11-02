<?php

declare(strict_types=1);

use app\modules\landing\models\Landing;
use app\widgets\Shortcodes;
use yii\web\View;

/**
 * @var View $this
 * @var Landing $landing
 */
Shortcodes::begin(); ?><?= $landing->text; ?><?php Shortcodes::end(); ?>
