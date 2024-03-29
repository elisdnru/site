<?php declare(strict_types=1);

use app\components\module\sitemap\Group;
use app\modules\user\models\Access;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Model[] $items
 * @var Group[] $groups
 */
$this->title = 'Карта сайта';

$this->registerMetaTag(['name' => 'description', 'content' => 'Карта сайта']);

$this->params['breadcrumbs'] = [
    'Карта сайта',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
}
?>

<h1>Карта сайта</h1>

<div class="sitemap">

    <?php foreach ($groups as $group): ?>
        <h2><?= Html::encode($group->name); ?></h2>
        <?= $this->render('_recursive', ['items' => $group->items, 'models' => [], 'parent' => 0]); ?>
    <?php endforeach; ?>

</div>
