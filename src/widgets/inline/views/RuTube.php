<?php declare(strict_types=1);

use yii\helpers\Html;

/** @var string $id */
?>
<iframe
    width="680"
    height="382"
    src="https://rutube.ru/play/embed/<?= Html::encode($id); ?>"
    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen
></iframe>
