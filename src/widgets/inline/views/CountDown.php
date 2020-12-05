<?php
use app\assets\CountDownAsset;
use yii\helpers\Html;

/**
 * @var string $title
 * @var string $date
 */

CountDownAsset::register($this);
?>

<div style="text-align: center; margin: 20px 0">
    <div style="display: inline-block">
        <div class="countdown" data-date="<?= Html::encode($date) ?>" data-title="<?= Html::encode($title) ?>"></div>
    </div>
</div>

