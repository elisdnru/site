<?php
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $model \app\modules\block\models\Block */
$this->pageTitle = 'Блоки';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Блоки',
];

$this->admin[] = ['label' => 'Добавить блок', 'url' => $this->createUrl('create')];
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create'); ?>">Добавить</a></p>
<h1>HTML-Блоки</h1>

<?php $this->renderPartial('_grid', ['model' => $model, 'dataProvider' => $dataProvider]); ?>
