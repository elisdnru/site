<?php declare(strict_types=1);

use app\modules\block\models\Block;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Block $block
 */
$this->title = 'Блок ' . $block->title;
$this->params['breadcrumbs'] = [
    'Блоки' => ['index'],
    $block->title,
];

$this->params['admin'][] = ['label' => 'Редактировать', 'url' => ['update', 'id' => $block->id]];
$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
?>

<h1>Просмотр блока &laquo;<?= Html::encode($block->title); ?>&raquo;</h1>

<?= $block->text; ?>
