<?php use app\components\widgets\FollowWidget;
use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\portfolio\models\Category;
use yii\caching\TagDependency;
use yii\widgets\Menu;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?php Portlet::begin(['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= FollowWidget::widget() ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Portlet::begin(['title' => 'Разделы портфолио']); ?>
<?= Menu::widget(['id' => 'portfolio_categories', 'items' => Category::model()->cache(0, new Tags('portfolio'))->getMenuList(1000)]) ?>
<?php Portlet::end();
