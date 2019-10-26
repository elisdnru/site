<?php
/** @var $model Block */

use app\modules\block\models\Block;
use yii\helpers\Url; ?>
<?php
$this->title = 'Редактор блоков';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Блоки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Блоки', 'url' => ['index']];
?>

<h1>Добавление блока</h1>

<?= $this->renderPartial('_form', ['model' => $model]); ?>
