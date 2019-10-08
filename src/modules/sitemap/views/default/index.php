<?php
/* @var $this Controller */

use app\components\Controller;
use app\modules\page\models\Page;
use app\modules\user\models\Access;

/* @var $page Page */
/* @var $items CModel[] */

$this->pageTitle = $page->pagetitle;
$this->description = $page->description;
$this->keywords = $page->keywords;

$this->breadcrumbs = [
    'Карта сайта',
];

if ($this->is(Access::ROLE_CONTROL)) {
    if ($page->id) {
        if ($this->moduleAllowed('page')) {
            $this->admin[] = ['label' => 'Редактировать страницу', 'url' => $this->createUrl('/page/pageAdmin/edit', ['id' => $page->id])];
        }
    }
}
?>

<h1><?php echo CHtml::encode($page->title); ?></h1>

<div class="sitemap">

    <!--noindex-->
    <h2>Страницы</h2>
    <?php $this->renderPartial('_recursive', ['models' => $items['Page'], 'parent' => 0]); ?>
    <!--/noindex-->

    <h2>Записи в блоге</h2>
    <ul>
        <?php foreach ($items['BlogPost'] as $model) : ?>
            <li><a href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <!--noindex-->
    <h2>Портфолио</h2>
    <ul>
        <?php foreach ($items['PortfolioWork'] as $model) : ?>
            <li><a href="<?php echo $model->url; ?>"><?php echo CHtml::encode($model->title); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <!--/noindex-->

</div>
