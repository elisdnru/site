<?php
/** @var $model Block */

$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];

use app\modules\block\models\Block; ?>

<h1>Редактирование блока</h1>

<p class="note">Код для вставки этого блока на страницу:
    <b><?= Yii::app()->controller->InlineWidgetsBehavior->startBlock ?>
        block|id=<?= CHtml::encode($model->alias) ?><?= Yii::app()->controller->InlineWidgetsBehavior->endBlock ?></b>
</p>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
