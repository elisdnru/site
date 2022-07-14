<?php declare(strict_types=1);

use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var int $category
 * @var Work[] $works
 * @var Pagination $pages
 */
$this->title = 'Работы портфолио';
$this->params['breadcrumbs'] = [
    'Портфолио',
];

if (Yii::$app->moduleAdminAccess->isGranted('portfolio')) {
    $this->params['admin'][] = ['label' => 'Категории', 'url' => ['/portfolio/admin/category/index']];
    $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => ['create', 'category' => $category]];
}
?>

<p class="float-right"><a href="<?= Url::to(['create', 'category' => $category]); ?>">Добавить</a>
</p>
<h1>Портфолио</h1>

<p id="saving" style="display:none;float:right">Saving...</p>

<form action="?" method="get">
    <p>
        Раздел: <?= Html::dropDownList('category', (string)$category, Category::find()->getTabList(), [
            'prompt' => 'Все разделы',
            'onchange' => 'this.form.submit()',
        ]); ?>
        <?= Html::submitButton('Выбрать'); ?>
    </p>
</form>

<br />

<table class="grid nomargin">
    <thead>
        <tr>
            <th width="50px"></th>
            <th width="20px"></th>
            <th>Заголовок</th>
            <th width="200px">Раздел</th>
            <th width="20px" title="Опубликовано">О</th>
            <th width="20px"></th>
            <th width="20px"></th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($works as $item) :
            $editUrl = Url::to(['update', 'id' => $item->id]);
            $delUrl = Url::to(['delete', 'id' => $item->id]);

            $togglePublic = Url::to(['toggle', 'id' => $item->id, 'param' => 'public']);
            ?>

            <tr class="<?= $item->public ? '' : 'disable'; ?>">
                <td width="50px" style="text-align: center">
                    <?php if ($item->image) : ?>
                        <a href="<?= $editUrl; ?>"><img style="width:50px;" src="<?= $item->getImageThumbUrl(50, 0); ?>" alt="<?= $item->title; ?>"></a>
                    <?php endif; ?>
                </td>
                <td style="text-align: center"><?= $item->sort; ?></td>
                <td><a href="<?= $editUrl; ?>"><?= $item->title; ?></a></td>
                <td width="200px" style="text-align: center">
                    <a href="<?= $editUrl; ?>"><?= $item->category->title; ?></a>
                </td>
                <td width="20px" style="text-align: center; padding: 0" title="Опубликовано">
                    <a class="ajax-post" href="<?= $togglePublic; ?>">
                        <?php if ($item->public) : ?>
                            <img src="/images/admin/yes.png" alt="">
                        <?php else : ?>
                            <img src="/images/admin/no.png" alt="">
                        <?php endif; ?>
                    </a>
                </td>
                <td width="20px" style="text-align: center">
                    <a href="<?= $editUrl; ?>"><img src="/images/admin/edit.png" alt="" title="Править"></a>
                </td>
                <td width="20px" style="text-align: center">
                    <a class="ajax-del" data-del="item_<?= $item->id; ?>" title="Удалить материал &laquo;<?= $item->title; ?>&raquo;" href="<?= $delUrl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<?= LinkPager::widget([
    'pagination' => $pages,
]); ?>

<style>
    .ui-state-highlight {
        height: 60px;
        background: #eee;
        border: #aaa 1px dashed;
        margin: 0;
    }
</style>
