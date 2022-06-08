<?php declare(strict_types=1);

use app\modules\page\forms\admin\PageForm;
use yii\web\View;

/**
 * @var View $this
 * @var PageForm $model
 */
$this->title = 'Редактор страниц';
$this->params['breadcrumbs'] = [
    'Страницы' => ['index'],
    'Редактор',
];

$this->params['admin'][] = ['label' => 'Страницы', 'url' => ['index']];
?>

<h1>Добавление страницы</h1>

<?= $this->render('_form', ['model' => $model]); ?>
