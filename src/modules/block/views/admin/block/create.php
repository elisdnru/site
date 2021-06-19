<?php declare(strict_types=1);

use app\modules\block\models\Block;
use yii\web\View;

/**
 * @var View $this
 * @var Block $model
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
