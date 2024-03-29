<?php declare(strict_types=1);

use app\components\DataProvider;
use app\components\PaginationFormatter;
use app\modules\blog\models\Tag;
use app\modules\user\models\Access;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var Tag $tag
 * @var DataProvider<Tag> $dataProvider
 */
$this->context->layout = 'index';

$this->title = 'Записи с меткой ' . $tag->title . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Записи с меткой ' . $tag->title . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, follow']);

$this->params['breadcrumbs'] = [
    'Блог' => ['/blog/default/index'],
    'Записи с меткой «' . $tag->title . '»',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Редактировать записи', 'url' => ['/blog/admin/post']];
        $this->params['admin'][] = ['label' => 'Добавить запись', 'url' => ['/blog/admin/post/create']];
    }
}
?>

<h1>Записи с меткой &laquo;<?= Html::encode($tag->title); ?>&raquo;</h1>

<?= $this->render('_loop', ['dataProvider' => $dataProvider]); ?>
