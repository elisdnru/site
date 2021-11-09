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

<?php Portlet::begin(['title' => 'Также я здесь']); ?>
<?= Follow::widget(); ?>
<?php Portlet::end(); ?>

<?php Portlet::begin(['title' => 'Разделы портфолио']); ?>
<?= Menu::widget(['id' => 'portfolio_categories', 'items' => Category::find()->cache(0, new TagDependency(['tags' => ['portfolio']]))->getMenuList($request->getPathInfo(), 1000)]); ?>
<?php Portlet::end();
