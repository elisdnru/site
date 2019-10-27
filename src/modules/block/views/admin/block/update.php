<?php
use app\modules\block\models\Block;
use yii\helpers\Html;

/** @var $model Block */

$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['view', 'id' => $model->id]];
?>

<h1>Редактирование блока</h1>

<p class="note">Код для вставки этого блока на страницу:
    <b>[{widget:block|id=<?= Html::encode($model->alias) ?>}]</b>
</p>

<?= $this->render('_form', ['model' => $model]); ?>
