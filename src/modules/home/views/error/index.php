<?php

use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $name
 * @var string $message
 * @var Exception $exception
 */

$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [
    'Ошибка ' . ($error['code'] ?? ''),
];
?>

<?php if (Yii::$app->user->can(Access::CONTROL)) {
    $this->params['admin'][] = ['label' => 'Вернуться на сайт', 'url' => ['default/index']];
} ?>

<h2><?= $name ?></h2>

<?php if ($message) : ?>
    <div class="flash flash-error">
        <?= nl2br(Html::encode($message)) ?>
    </div>
<?php endif; ?>

<p>Так получилось...</p>
<p><a href="/">На главную</a></p>
