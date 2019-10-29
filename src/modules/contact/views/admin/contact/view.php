<?php
/** @var $this View */

use app\modules\contact\models\Contact;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/** @var $next Contact */
/** @var $prev Contact */
/** @var $model Contact */

$this->title = 'Сообщение';
$this->params['breadcrumbs'] = [
    'Сообщения' => ['index'],
    'Сообщение №' . $model->id,
];

$this->params['admin'][] = ['label' => 'Сообщения', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Удалить', 'url' => ['delete', 'id' => $model->id]];
?>

<div style="float:right">

    <?= Html::beginForm(Url::to(['delete', 'id' => $model->id])) ?>
    <?= Html::submitButton('Удалить сообщение') ?>
    <?= Html::endForm() ?>
</div>

<h1>Сообщение №<?= $model->id ?></h1>

<?= Html::beginForm(Url::to(['toggle', 'id' => $model->id, 'attribute' => 'status'])) ?>
<?php if ($model->status) : ?>
    <?= Html::submitButton('Отметить непрочитанным') ?>
<?php else : ?>
    <?= Html::submitButton('Прочитать') ?>
<?php endif; ?>
<?= Html::endForm() ?>

<br />

<table class="border">
    <tr>
        <td>Дата</td>
        <td><?= $model->date ?></td>
    </tr>
    <?php if ($model->pagetitle) : ?>
        <tr>
        <td width="150">Со страницы</td>
        <td><?= Html::encode($model->pagetitle) ?></td></tr><?php
    endif; ?>
    <tr>
        <td>Автор</td>
        <td><?= Html::encode($model->name) ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?= Html::encode($model->email) ?></td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td><?= Html::encode($model->phone) ?></td>
    </tr>
    <tr>
        <td>Сообщение</td>
        <td><?= nl2br(Html::encode($model->text)) ?></td>
    </tr>
</table>

<?php if ($next) : ?>
    <p class="nomargin" style="float: right">
        <a href="<?= Url::to(['view', 'id' => $next->id]) ?>">следующее сообщение &rarr;</a>
    </p>
<?php endif; ?>
<?php if ($prev) : ?>
    <p class="nomargin" style="float: left">
        <a href="<?= Url::to(['view', 'id' => $prev->id]) ?>">&larr; предыдущее сообщение</a>
    </p>
<?php endif; ?>

<div class="clear"></div>
