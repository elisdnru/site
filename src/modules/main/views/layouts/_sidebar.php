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
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= FollowWidget::widget() ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Разделы блога']); ?>
<?= Menu::widget(['id' => 'blog_categories', 'items' => Category::model()->cache(0, new Tags('blog'))->getMenuList(1000)]) ?>
<?php Yii::app()->controller->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Метки']); ?>
    <?= TagCloudWidget::widget() ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class); ?>
    <?= CalendarWidget::widget() ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Профиль']); ?>
<?= LoginFormWidget::widget() ?>
<?php Yii::app()->controller->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Недавно обновившиеся записи']); ?>
    <?= UpdatedPostsWidget::widget(['limit' => 10]) ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar_second']) ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
