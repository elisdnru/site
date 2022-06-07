<?php declare(strict_types=1);

use app\modules\blog\models\Post;
use yii\web\View;

/**
 * @var View $this
 * @var Post $model
 */
$this->title = 'Редактор записи блога';
$this->params['breadcrumbs'] = [
    'Записи блога' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Все записи', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category/index']];
$this->params['admin'][] = ['label' => 'Группы', 'url' => ['/blog/admin/group/index']];
$this->params['admin'][] = ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']];

?>

<h1>Добавление записи</h1>

<?= $this->render('_form', ['model' => $model]); ?>


