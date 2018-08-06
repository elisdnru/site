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

<?php if (Yii::app()->moduleManager->active('portfolio')) : ?>
    <?php Yii::import('portfolio.models.PortfolioCategory'); ?>

    <?php $this->beginWidget('DPortlet', ['title' => 'Разделы портфолио']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => PortfolioCategory::model()->cache(0, new Tags('portfolio'))->getMenuList(1000), 'htmlOptions' => ['class' => 'collapsed']]); ?>
    <?php $this->endWidget(); ?>

<?php endif;
