<?php use app\components\widgets\Portlet;
use app\extensions\cachetagging\Tags;
use app\modules\block\widgets\BlockWidget;
use app\modules\user\widgets\LoginFormWidget;

if ($this->route !== 'user/default/login') : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['title' => 'Личный кабинет']); ?>
    <?= LoginFormWidget::widget() ?>
    <?php Yii::app()->controller->endWidget(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new Tags('block')])) : ?>
    <?php Yii::app()->controller->beginWidget(Portlet::class, ['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']) ?>
    <?php Yii::app()->controller->endWidget(); ?>
    <?php $this->endCache(); ?>
<?php endif;
