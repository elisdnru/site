<?php declare(strict_types=1);

use yii\helpers\Html;

/** @var string $id */
?>
<iframe
    width="680"
    height="382"
    src="https://www.youtube.com/embed/<?= Html::encode($id); ?>"
    allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen
></iframe>
