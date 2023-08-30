<?php declare(strict_types=1);

use app\modules\block\widgets\BlockWidget;
use app\modules\blog\models\Category;
use app\modules\blog\widgets\TagCloudWidget;
use app\modules\edu\widgets\PromotedEpisodes;
use app\modules\user\widgets\LoginFormWidget;
use app\widgets\Follow;
use app\widgets\Portlet;
use yii\caching\TagDependency;
use yii\web\View;
use yii\widgets\Menu;

/**
 * @var View $this
 */
$request = Yii::$app->request;
?>

<?php Portlet::begin(['title' => 'Также я здесь']); ?>
<?= Follow::widget(); ?>
<?php Portlet::end(); ?>

<?php if ($this->beginCache('banner_sidebar', ['dependency' => new TagDependency(['tags' => 'block'])])): ?>
    <?php Portlet::begin(['htmlOptions' => ['class' => 'portlet banner']]); ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar']); ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Portlet::begin(['title' => 'Разделы блога']); ?>
<?= Menu::widget(['id' => 'blog_categories', 'items' => Category::find()->cache(0, new TagDependency(['tags' => ['blog']]))->getMenuList($request->getPathInfo(), 1000)]); ?>
<?php Portlet::end(); ?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'blog'])])): ?>
    <?php Portlet::begin(['title' => 'Метки']); ?>
    <?= TagCloudWidget::widget(); ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Portlet::begin(['title' => 'Профиль']); ?>
<?= LoginFormWidget::widget(); ?>
<?php Portlet::end(); ?>

<?php if ($this->beginCache('banner_sidebar_second', ['dependency' => new TagDependency(['tags' => 'block'])])): ?>
    <?= BlockWidget::widget(['id' => 'banner_sidebar_second']); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<div class="portlet">
    <div class="portlet-title">Скринкасты</div>
</div>

<?= PromotedEpisodes::widget(['limit' => 6]); ?>
