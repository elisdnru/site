<?php use app\extensions\cachetagging\Tags;
use app\modules\blog\models\Category;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?php $this->widget(\app\components\widgets\FollowWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Разделы блога']); ?>
<?php $this->widget('zii.widgets.CMenu', ['items' => Category::model()->cache(0, new Tags('blog'))->getMenuList(1000)]); ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Метки']); ?>
    <?php $this->widget(\app\modules\blog\widgets\TagCloudWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class); ?>
    <?php $this->widget(\app\modules\blog\widgets\CalendarWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Профиль']); ?>
<?php $this->widget(\app\modules\user\widgets\LoginFormWidget::class); ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Недавно обновившиеся записи']); ?>
    <?php $this->widget(\app\modules\blog\widgets\UpdatedPostsWidget::class, ['limit' => 10]); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_sidebar_second']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
