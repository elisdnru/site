<?php
/** @var $user \app\modules\user\models\User */
use yii\helpers\Html;
?>
<p>Запрошен сброс пароля на сайте <?= Yii::$app->request->getHostInfo() ?></p>

<p>Временный пароль: <b><?= Html::encode($user->new_password) ?></b></p>

<p>Войдите на сайт и смените пароль в кабинете.</p>
