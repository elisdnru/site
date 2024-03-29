<?php declare(strict_types=1);

use app\modules\blog\forms\admin\TagForm;
use yii\web\View;

/**
 * @var View $this
 * @var TagForm $model
 */
$this->title = 'Редактор метки блога';
$this->params['breadcrumbs'] = [
    'Блоги' => ['/blog/admin/post'],
    'Метки' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Метки', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post/index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
?>

<h1>Добавление метки блога</h1>

<?= $this->render('_form', ['model' => $model]); ?>
