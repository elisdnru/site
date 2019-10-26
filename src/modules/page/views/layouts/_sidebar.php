<?php use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\block\widgets\BlockWidget;
use app\modules\user\widgets\LoginFormWidget;

if ($this->context->route !== 'user/default/login') : ?>
    <?php Portlet::begin(['title' => 'Личный кабинет']); ?>
    <?= LoginFormWidget::widget() ?>
    <?php Portlet::end(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php Portlet::begin(['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif;
