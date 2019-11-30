<?php use app\widgets\Follow;
use app\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\models\Category;
use app\modules\blog\widgets\CalendarWidget;
use app\modules\blog\widgets\TagCloudWidget;
use app\modules\blog\widgets\UpdatedPostsWidget;
use app\modules\user\widgets\LoginFormWidget;
use yii\caching\TagDependency;
use yii\widgets\Menu;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?php Portlet::begin(['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= Follow::widget() ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?php Portlet::begin(['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Portlet::begin(['title' => 'Разделы блога']); ?>
<?= Menu::widget(['id' => 'blog_categories', 'items' => Category::model()->cache(0, new Tags('blog'))->getMenuList(1000)]) ?>
<?php Portlet::end(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
    <?php Portlet::begin(['title' => 'Метки']); ?>
    <?= TagCloudWidget::widget() ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::$app->request->get('date'), ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
    <?php Portlet::begin(); ?>
    <?= CalendarWidget::widget() ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php Portlet::begin(['title' => 'Профиль']); ?>
<?= LoginFormWidget::widget() ?>
<?php Portlet::end(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'blog'])])) : ?>
    <?php Portlet::begin(['title' => 'Недавно обновившиеся записи']); ?>
    <?= UpdatedPostsWidget::widget(['limit' => 10]) ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar_second']) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
