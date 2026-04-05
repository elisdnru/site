<?php declare(strict_types=1);

use Webmozart\Assert\Assert;
use yii\helpers\Html;
use yii\web\Application;

/**
 * @var string $password
 */
$request = Assert::isInstanceOf(Yii::$app, Application::class)->request;
?>
<p>Запрошен сброс пароля на сайте <?= $request->getHostInfo(); ?></p>

<p>Временный пароль: <b><?= Html::encode($password); ?></b></p>

<p>Войдите на сайт и смените пароль в кабинете.</p>
