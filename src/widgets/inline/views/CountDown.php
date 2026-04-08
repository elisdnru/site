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

<div style="text-align: center; margin: 20px 0; display: flex; justify-content: center; align-items: center;">
    <div>
        <div style="text-align: center;"><?= Html::encode($title); ?></div>
        <div class="countdown" data-date="<?= Html::encode($date); ?>">
            <div class="countdown-item countdown-days" data-title="д">XX</div>
            <div class="countdown-separator">:</div>
            <div class="countdown-item countdown-hours" data-title="ч">XX</div>
            <div class="countdown-separator">:</div>
            <div class="countdown-item countdown-minutes" data-title="м">XX</div>
            <div class="countdown-separator">:</div>
            <div class="countdown-item countdown-seconds" data-title="с">XX</div>
        </div>
    </div>
</div>

