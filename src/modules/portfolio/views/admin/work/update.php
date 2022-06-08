<?php declare(strict_types=1);

use app\modules\portfolio\forms\admin\WorkForm;
use app\modules\portfolio\models\Work;
use yii\web\View;

/**
 * @var View $this
 * @var Work $work
 * @var WorkForm $model
 */
$this->title = 'Редактор работы';
$this->params['breadcrumbs'] = [
    'Портфолио' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Просмотр', 'url' => [
    '/portfolio/work/show',
    'category' => $work->category->getPath(),
    'id' => $work->id,
    'slug' => $work->slug,
]];
$this->params['admin'][] = ['label' => 'Работы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];
?>

<h1>Редактирование работы</h1>

<?= $this->render('_form', ['model' => $model, 'work' => $work]); ?>
