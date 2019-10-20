<?php
/** @var $model \app\modules\block\models\Block */
?>
<?php
$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Блоки', 'url' => $this->createUrl('index')];
?>

<h1>Добавление блока</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
