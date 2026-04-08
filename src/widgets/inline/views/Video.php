<?php declare(strict_types=1);

use yii\helpers\Html;

/** @var string $src */
?>
<iframe
    width="680"
    height="382"
    src="<?= Html::encode($src); ?>"
    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen
></iframe>
