<?php use app\extensions\cachetagging\Tags;

if ($this->route !== 'user/default/login') : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Личный кабинет']); ?>
    <?php $this->widget(\app\modules\user\widgets\LoginFormWidget::class); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->menu) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Управление']); ?>
    <?php $this->widget('zii.widgets.CMenu', ['items' => $this->menu]); ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?php $this->widget(\app\modules\block\widgets\BlockWidget::class, ['id' => 'banner_sidebar']); ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif;
