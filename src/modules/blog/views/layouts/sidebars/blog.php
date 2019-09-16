<!--noindex-->
<?php use app\extensions\cachetagging\Tags;
use app\modules\blog\models\BlogCategory;

if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['title' => 'Также я здесь']); ?>
    <?php $this->widget(\app\modules\follow\widgets\FollowWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php if ($this->menu) : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->route == 'blog/post/show') : ?>
    <!--noindex-->
<?php endif; ?>
<?php if ($this->route == 'blog/post/show') : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DNofollowWidget::class); ?>
<?php endif; ?>
<?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['title' => 'Разделы блога']); ?>
<?php $this->widget('zii.widgets.CMenu', ['items' => BlogCategory::model()->cache(0, new Tags('blog'))->getMenuList(1000), 'htmlOptions' => ['class' => 'collapsed']]); ?>
<?php $this->endWidget(); ?>
<?php if ($this->route == 'blog/post/show') : ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>
<?php if ($this->route == 'blog/post/show') : ?>
    <!--/noindex-->
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['title' => 'Метки']); ?>
    <?php $this->widget(\app\modules\blog\widgets\TagCloudWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class); ?>
    <?php $this->widget(\app\modules\blog\widgets\BlogCalendarWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<!--noindex-->
<?php $this->beginWidget(\app\modules\main\components\widgets\DPortlet::class, ['title' => 'Профиль']); ?>
<?php $this->widget(\app\modules\user\widgets\LoginFormWidget::class); ?>
<?php $this->endWidget(); ?>
<!--/noindex-->

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_sidebar_second']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
