<?php declare(strict_types=1);

use app\modules\block\forms\admin\BlockForm;
use yii\web\View;

/**
 * @var View $this
 * @var BlockForm $model
 */
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
