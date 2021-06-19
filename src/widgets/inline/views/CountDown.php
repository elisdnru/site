<?php declare(strict_types=1);

use app\assets\CountDownAsset;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $title
 * @var string $date
 */
CountDownAsset::register($this);
?>

<div style="text-align: center; margin: 20px 0">
    <div style="display: inline-block">
        <div class="countdown" data-date="<?= Html::encode($date); ?>" data-title="<?= Html::encode($title); ?>"></div>
    </div>
</div>

