<?php
use yii\helpers\Html;

/** @var string $password */
?>
<p>Запрошен сброс пароля на сайте <?= Yii::$app->request->getHostInfo() ?></p>

<p>Временный пароль: <b><?= Html::encode($password) ?></b></p>

<p>Войдите на сайт и смените пароль в кабинете.</p>
