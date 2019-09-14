<?php
/* @var $this DAdminController */

use app\modules\contact\models\Contact;
use app\modules\main\components\DAdminController;

/* @var $next Contact */
/* @var $prev Contact */

$this->pageTitle = 'Сообщение';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Сообщения' => ['index'],
    'Сообщение №' . $model->id,
];

$this->admin[] = ['label' => 'Сообщения', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Удалить', 'url' => $this->createUrl('delete', ['id' => $model->id])];

$this->info = 'Вы можете настроить отправку сообщений на свою почту в параметрах';
?>

<div style="float:right">
    <?php echo CHtml::beginForm($this->createUrl('delete', ['id' => $model->id])); ?>
    <?php echo CHtml::submitButton('Удалить сообщение'); ?>
    <?php echo CHtml::endForm(); ?>
</div>

<h1>Сообщение №<?php echo $model->id; ?></h1>

<p><?php echo $model->date; ?></p>
<table class="border">
    <?php if ($model->pagetitle) : ?>
        <tr>
        <td width="150">Со страницы</td>
        <td><?php echo CHtml::encode($model->pagetitle); ?></td></tr><?php
    endif; ?>
    <tr>
        <td>Автор</td>
        <td><?php echo CHtml::encode($model->name); ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo CHtml::encode($model->email); ?></td>
    </tr>
    <tr>
        <td>Телефон</td>
        <td><?php echo CHtml::encode($model->phone); ?></td>
    </tr>
    <tr>
        <td>Сообщение</td>
        <td><?php echo nl2br(CHtml::encode($model->text)); ?></td>
    </tr>
</table>
<?php if ($next) :
?><p class="nomargin floatright">
    <a href="<?php echo $this->createUrl('view', ['id' => $next->id]); ?>">следующее сообщение &rarr;</a>
    <?php endif; ?>
<?php if ($prev) :
?><p class="nomargin floatleft">
    <a href="<?php echo $this->createUrl('view', ['id' => $prev->id]); ?>">&larr; предыдущее сообщение</a>
    <?php endif; ?>

<div class="clear"></div>
