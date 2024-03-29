<?php declare(strict_types=1);

use app\components\DataProvider;
use app\components\PaginationFormatter;
use app\modules\blog\models\Post;
use app\modules\user\models\Access;
use yii\web\View;

/**
 * @var View $this
 * @var DataProvider<Post> $dataProvider
 */
$this->context->layout = 'index';

$this->title = 'Блог' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Официальный блог web-разработчика Дмитрия Елисеева. Статьи по разработке сайтов на фреймворках, программированию на PHP, рефакторингу web-приложений и повышению личной продуктивности. ' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->params['breadcrumbs'] = [
    'Блог',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
        $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/blog/admin/category']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('blog') && Yii::$app->moduleAdminAccess->isGranted('comment')) {
        foreach (Yii::$app->moduleAdminNotifications->notifications('blog') as $notification) {
            $this->params['admin'][] = $notification;
        }
    }
}
?>

<h1>Официальный блог</h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
