<?php use app\components\widgets\FollowWidget;
use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\block\widgets\BlockWidget;
use app\modules\blog\models\Category;
use app\modules\blog\widgets\CalendarWidget;
use app\modules\blog\widgets\TagCloudWidget;
use app\modules\blog\widgets\UpdatedPostsWidget;
use app\modules\user\widgets\LoginFormWidget;
use yii\widgets\Menu;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= FollowWidget::widget() ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php $this->beginWidget(Portlet::class, ['title' => 'Разделы блога']); ?>
<?= Menu::widget(['id' => 'blog_categories', 'items' => Category::model()->cache(0, new Tags('blog'))->getMenuList(1000)]) ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['title' => 'Метки']); ?>
    <?= TagCloudWidget::widget() ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(Portlet::class); ?>
    <?= CalendarWidget::widget() ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php $this->beginWidget(Portlet::class, ['title' => 'Профиль']); ?>
<?= LoginFormWidget::widget() ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['title' => 'Недавно обновившиеся записи']); ?>
    <?= UpdatedPostsWidget::widget(['limit' => 10]) ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar_second']) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
