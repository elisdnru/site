<?php use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\block\widgets\BlockWidget;
use app\modules\user\widgets\LoginFormWidget;

if ($this->route !== 'user/default/login') : ?>
    <?php $this->beginWidget(Portlet::class, ['title' => 'Личный кабинет']); ?>
    <?= LoginFormWidget::widget() ?>
    <?php $this->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php $this->beginWidget(Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php $this->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif;
