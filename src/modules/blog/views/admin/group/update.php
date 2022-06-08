<?php declare(strict_types=1);

use app\modules\blog\forms\admin\GroupForm;
use app\modules\blog\models\Group;
use yii\web\View;

/**
 * @var View $this
 * @var GroupForm $model
 * @var Group $group
 */
$this->title = 'Редактор метки блога';
$this->params['breadcrumbs'] = [
    'Записи' => ['/blog/admin/post'],
    'Группы записей' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']];
?>

<h1>Редактирование группы блога</h1>

<?= $this->render('_form', ['model' => $model]); ?>
