<?php
/** @var $model \app\modules\block\models\Block */

$this->title = 'Редактор блоков';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->admin[] = ['label' => 'Блоки', 'url' => $this->createUrl('index')];
$this->admin[] = ['label' => 'Просмотр', 'url' => $this->createUrl('view', ['id' => $model->id])];

?>

<h1>Редактирование блока</h1>

<p class="note">Код для вставки этого блока на страницу:
    <b><?php echo Yii::app()->controller->InlineWidgetsBehavior->startBlock; ?>
        block|id=<?php echo CHtml::encode($model->alias); ?><?php echo Yii::app()->controller->InlineWidgetsBehavior->endBlock; ?></b>
</p>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
