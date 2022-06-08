<?php declare(strict_types=1);

use app\modules\page\forms\admin\PageForm;
use app\modules\page\models\Page;
use yii\web\View;

/**
 * @var View $this
 * @var Page $page
 * @var PageForm $model
 */
$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['admin'][] = ['label' => 'Просмотр', 'url' => ['/page/page/show', 'path' => $page->getPath()]];
?>

<h1>Редактирование страницы</h1>

<?= $this->render('_form', ['model' => $model]); ?>
