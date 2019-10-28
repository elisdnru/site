<?php
use app\modules\block\models\Block;

/** @var $model Block */
?>
<?php
$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
    'Блоки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
?>

<h1>Добавление блока</h1>

<?= $this->render('_form', ['model' => $model]); ?>
