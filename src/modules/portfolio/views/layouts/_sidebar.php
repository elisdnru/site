<?php declare(strict_types=1);

use app\modules\portfolio\models\Category;
use app\widgets\Follow;
use app\widgets\Portlet;
use yii\caching\TagDependency;
use yii\web\Request;
use yii\web\View;
use yii\widgets\Menu;

/**
 * @var View $this
 * @var Request $request
 */
$request = Yii::$app->request;
?>

<?php if ($this->beginCache(__FILE__ . __LINE__, ['dependency' => new TagDependency(['tags' => 'block'])])) : ?>
    <?php Portlet::begin(['title' => 'Также я здесь', 'htmlOptions' => ['class' => 'portlet portlet-fixed']]); ?>
    <?= Follow::widget(); ?>
    <?php Portlet::end(); ?>
    <?php $this->endCache(); ?>
<?php endif; ?>

<?php Portlet::begin(['title' => 'Разделы портфолио']); ?>
<?= Menu::widget(['id' => 'portfolio_categories', 'items' => Category::find()->cache(0, new TagDependency(['tags' => ['portfolio']]))->getMenuList($request->getPathInfo(), 1000)]); ?>
<?php Portlet::end();
