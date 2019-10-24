<?php
/** @var $this AdminController */

use app\modules\contact\models\Contact;
use app\components\AdminController;

/** @var $next Contact */
/** @var $prev Contact */
/** @var $model Contact */

$this->title = 'Сообщение';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Сообщения' => ['index'],
    'Сообщение №' . $model->id,
];

$this->params['admin'][] = ['label' => 'Сообщения', 'url' => $this->createUrl('index')];
$this->params['admin'][] = ['label' => 'Удалить', 'url' => $this->createUrl('delete', ['id' => $model->id])];
?>

<div style="float:right">

    <?= CHtml::beginForm($this->createUrl('delete', ['id' => $model->id])) ?>
    <?= CHtml::submitButton('Удалить сообщение') ?>
    <?= CHtml::endForm() ?>
</div>

<h1>Сообщение №<?= $model->id ?></h1>

<?= CHtml::beginForm($this->createUrl('toggle', ['id' => $model->id, 'attribute' => 'status'])) ?>
<?php if ($model->status): ?>
    <?= CHtml::submitButton('Отметить непрочитанным') ?>
<?php else: ?>
    <?= CHtml::submitButton('Прочитать') ?>
<?php endif; ?>
<?= CHtml::endForm() ?>

<br />

<table class="border">
    <tr>
        <td>Дата</td>
        <td><?= $model->date ?></td>
    </tr>
    <?php if ($model->pagetitle) : ?>
        <tr>
        <td width="150">Со страницы</td>
        <td><?= CHtml::encode($model->pagetitle) ?></td></tr><?php
    endif; ?>
    <tr>
        <td>Автор</td>
        <td><?= CHtml::encode($model->name) ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?= CHtml::encode($model->email) ?></td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td><?= CHtml::encode($model->phone) ?></td>
    </tr>
    <tr>
        <td>Сообщение</td>
        <td><?= nl2br(CHtml::encode($model->text)) ?></td>
    </tr>
</table>
<?php if ($next) :
?><p class="nomargin" style="float: right">
    <a href="<?= $this->createUrl('view', ['id' => $next->id]) ?>">следующее сообщение &rarr;</a>
    <?php endif; ?>
<?php if ($prev) :
?><p class="nomargin" style="float: left">
    <a href="<?= $this->createUrl('view', ['id' => $prev->id]) ?>">&larr; предыдущее сообщение</a>
    <?php endif; ?>

<div class="clear"></div>
