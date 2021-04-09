<?php

use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Block $model
 */

$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
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

<?= $this->render('_form', ['model' => $model]) ?>
