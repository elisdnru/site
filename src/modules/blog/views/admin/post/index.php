<?php declare(strict_types=1);

use app\components\DataProvider;
use app\modules\blog\models\Category;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View $this
 * @var DataProvider<Post> $dataProvider
 * @var Post $model
 */
$this->title = 'Записи блога';
$this->params['breadcrumbs'] = [
    'Записи блога',
];

$this->params['admin'] = [
    ['label' => 'Добавить', 'url' => ['create']],
    ['label' => 'Категории', 'url' => ['/blog/admin/category/index']],
    ['label' => 'Метки', 'url' => ['/blog/admin/tag/index']],
    ['label' => 'Тематические группы', 'url' => ['/blog/admin/group/index']],
];
?>

<p class="float-right"><a href="<?= Url::to(['create']); ?>">Добавить</a></p>
<h1>Записи блога</h1>

<div class="grid-view">
    <div class="summary"><?= $dataProvider->getCount(); ?> из <?= $dataProvider->getTotalCount(); ?></div>
    <form action="?" method="get">
        <table class="items">
            <thead>
                <tr>
                    <th><?= $dataProvider->getSort()->link('t.date', ['class' => 'sort-link', 'label' => 'Дата']); ?></th>
                    <th><?= $dataProvider->getSort()->link('t.title', ['class' => 'sort-link', 'label' => 'Заголовок']); ?></th>
                    <th><?= $dataProvider->getSort()->link('t.category_id', ['class' => 'sort-link', 'label' => 'Раздел']); ?></th>
                    <th><?= $dataProvider->getSort()->link('t.group_id', ['class' => 'sort-link', 'label' => 'Группа']); ?></th>
                    <th><?= $dataProvider->getSort()->link('t.public', ['class' => 'sort-link', 'label' => 'О']); ?></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr class="filters">
                    <td><?= Html::activeTextInput($model, 'date'); ?></td>
                    <td><?= Html::activeTextInput($model, 'title'); ?></td>
                    <td><?= Html::activeDropDownList($model, 'category_id', Category::find()->getTabList(), ['prompt' => '']); ?></td>
                    <td><?= Html::activeDropDownList($model, 'group_id', Group::find()->getAssocList(), ['prompt' => '']); ?></td>
                    <td><?= Html::activeDropDownList($model, 'public', [1 => 'Опубликовано', 0 => 'Не опубликовано'], ['prompt' => '']); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getItems() as $item) : ?>
                    <tr>
                        <td style="width:130px; text-align:center">
                            <?= Html::encode($item->date); ?>
                        </td>
                        <td>
                            <a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><?= Html::encode($item->title); ?></a>
                        </td>
                        <td><?= Html::encode($item->category->getFullTitle()); ?></td>
                        <td><?= $item->group ? Html::encode($item->group->title) : ''; ?></td>
                        <td style="width:30px; text-align:center">
                            <?php if ($item->public) : ?>
                                <img src="/images/admin/yes.png" alt="">
                            <?php else : ?>
                                <img src="/images/admin/no.png" alt="">
                            <?php endif; ?>
                        </td>
                        <td class="button-column"><a href="<?= Url::to(['view', 'id' => $item->id]); ?>"><span class="icon view"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['update', 'id' => $item->id]); ?>"><span class="icon edit"></span></a></td>
                        <td class="button-column"><a href="<?= Url::to(['delete', 'id' => $item->id]); ?>" class="ajax-del"><span class="icon delete"></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" style="visibility: hidden"></button>
    </form>
</div>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>

