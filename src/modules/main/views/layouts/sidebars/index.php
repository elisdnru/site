<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget('DPortlet', ['title' => 'Также я здесь']); ?>
    <?php $this->widget('follow.widgets.FollowWidget'); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if ($this->menu) : ?>
    <?php $this->beginWidget('DPortlet', ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget('DPortlet', ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget('application.modules.block.widgets.BlockWidget', ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php if (Yii::app()->moduleManager->active('blog')) : ?>
    <?php Yii::import('blog.models.BlogCategory'); ?>
    <?php $this->beginWidget('DPortlet', ['title' => 'Разделы блога']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => BlogCategory::model()->cache(0, new Tags('blog'))->getMenuList(1000), 'htmlOptions' => ['class' => 'collapsed']]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if (Yii::app()->moduleManager->active('blog')) : ?>
    <?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
        <?php $this->beginWidget('DPortlet', ['title' => 'Метки']); ?>
        <?php $this->widget('blog.widgets.TagCloudWidget'); ?>
        <?php $this->endWidget(); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>
<?php endif; ?>

<!--noindex-->
<?php if (Yii::app()->moduleManager->active('blog')) : ?>
    <?php if ($this->beginCache(__FILE__ . __LINE__ . Yii::app()->request->getQuery('date'), ['dependency' => new Tags('blog')])) : ?>
        <?php $this->beginWidget('DPortlet'); ?>
        <?php $this->widget('blog.widgets.BlogCalendarWidget'); ?>
        <?php $this->endWidget(); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>
<?php endif; ?>
<!--/noindex-->

<?php $this->beginWidget('DPortlet', ['title' => 'Профиль']); ?>
<?php $this->widget('user.widgets.LoginFormWidget'); ?>
<?php $this->endWidget(); ?>

<?php if (Yii::app()->moduleManager->active('blog')) : ?>
    <?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new Tags('blog')])) : ?>
        <?php $this->beginWidget('DPortlet', ['title' => 'Недавно обновившиеся записи']); ?>
        <?php $this->widget('blog.widgets.UpdatedPostsWidget', ['limit' => 5]); ?>
        <?php $this->endWidget(); ?>
        <?php $this->endCache(); ?>
    <?php endif; ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new Tags('block')])) : ?>
    <?php $this->widget('application.modules.block.widgets.BlockWidget', ['id' => 'banner_sidebar_second']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>
