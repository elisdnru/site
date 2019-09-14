<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Также я здесь']); ?>
    <?php $this->widget(\FollowWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->menu) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget(\BlockWidget::class, ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php $this->beginWidget(\DPortlet::class, ['title' => 'Разделы блога']); ?>
<?php $this->widget('zii.widgets.CMenu', ['items' => BlogCategory::model()->cache(0, new Tags('blog'))->getMenuList(1000), 'htmlOptions' => ['class' => 'collapsed']]); ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Метки']); ?>
    <?php $this->widget(\TagCloudWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<!--noindex-->
<?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\DPortlet::class); ?>
    <?php $this->widget(\BlogCalendarWidget::class); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
<!--/noindex-->

<?php $this->beginWidget(\DPortlet::class, ['title' => 'Профиль']); ?>
<?php $this->widget(\LoginFormWidget::class); ?>
<?php $this->endWidget(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
    <?php $this->beginWidget(\DPortlet::class, ['title' => 'Недавно обновившиеся записи']); ?>
    <?php $this->widget(\UpdatedPostsWidget::class, ['limit' => 5]); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?php $this->widget(\BlockWidget::class, ['id' => 'banner_sidebar_second']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
