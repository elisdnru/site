<?php use app\extensions\cachetagging\Tags;

if ($this->route !== 'user/default/login') : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['title' => 'Личный кабинет']); ?>
    <?= \app\modules\user\widgets\LoginFormWidget::widget() ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(\app\components\widgets\Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= \app\modules\block\widgets\BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif;
