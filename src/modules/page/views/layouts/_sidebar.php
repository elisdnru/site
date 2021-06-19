<?php declare(strict_types=1);

use app\modules\block\widgets\BlockWidget;
use app\modules\user\widgets\LoginFormWidget;
use app\widgets\Portlet;
use yii\caching\TagDependency;
use yii\web\View;

/**
 * @var View $this
 */
?>

<?php if ($this->context->route !== 'user/default/login') : ?>
    <?php Portlet::begin(['title' => 'Личный кабинет']); ?>
    <?= LoginFormWidget::widget(); ?>
    <?php Portlet::end(); ?>
<?php endif; ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?php Portlet::begin(['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']); ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif;
