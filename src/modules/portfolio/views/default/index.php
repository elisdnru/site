<?php

use app\components\PaginationFormatter;
use app\modules\portfolio\models\Category;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;

/** @var $dataProvider ActiveDataProvider */
/** @var $categories Category[] */
$this->context->layout = 'index';

$this->title = 'Портфолио' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Портфолио фрилансера Дмитрия Елисеева. Примеры работ по дизайну, вёрстке и программированию сайтов.'
]);

$this->params['breadcrumbs'] = [
    'Портфолио',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAccess->isGranted('portfolio')) {
        $this->params['admin'][] = ['label' => 'Работы', 'url' => ['/portfolio/admin/work/index']];
        $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['/portfolio/admin/work/create']];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];
    }
}
?>

<h1>Портфолио</h1>

<?php if ($categories) : ?>
    <div class="subpages">
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li><a href="<?= $category->getUrl() ?>"><?= $category->title ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
    </div>
<?php endif; ?>

<?php if (Yii::$app->request->get('page', 1) == 1) : ?>
    <p class="portfolio-description">
        <span>В 2013-14 году все услуги<br />предоставлялись совместно со студией</span>
        <img src="/images/webdoka.jpg" alt="" />
        <a rel="noreferrer noopener" target="_blank" href="https://webdoka.ru/portfolio/">Портфолио студии</a>
    </p>
    <h2>Работы 2008-2012 года:</h2>
<?php endif; ?>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]) ?>
