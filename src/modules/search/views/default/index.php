<?php

use app\components\InlineWidgetsBehavior;
use app\components\PaginationFormatter;
use app\modules\search\components\SearchHighlighter;
use app\modules\search\models\Search;
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var View|InlineWidgetsBehavior $this
 * @var ActiveDataProvider $dataProvider
 * @var string $query
 */

$this->title = 'Поиск по сайту' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Поиск по сайту' . PaginationFormatter::appendix($dataProvider->getPagination()->getPage() + 1),
]);

$this->params['breadcrumbs'] = [
    'Поиск по сайту',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleAdminAccess->isGranted('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
    }
    if (Yii::$app->moduleAdminAccess->isGranted('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
}
?>

<h1>Поиск по сайту</h1>

<?= SearchFormWidget::widget() ?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $model) : ?>
        <?php /** @var Search $model */ ?>
        <article class="entry list">
            <header>
                <h2>
                    <a href="<?= $model->material->getUrl() ?>"><?= SearchHighlighter::getFragment(strip_tags($model->title), $query) ?></a>
                </h2>
                <?php if ($model->material->hasAttribute('image')) : ?>
                    <?php
                    $properties = array_filter([
                        'width' => $model->material->image_width,
                        'height' => $model->material->image_height,
                    ]);
                    ?>
                    <p class="thumb">
                        <a href="<?= $model->material->getUrl() ?>"><?= Html::img($model->material->getImageThumbUrl(), $properties) ?></a>
                    </p>
                <?php endif; ?>
            </header>
            <div class="short"><?= SearchHighlighter::getFragment(strip_tags($this->clearWidgets($model->text)), $query) ?>
                ...
            </div>
            <div class="clear"></div>
        </article>

    <?php endforeach; ?>
</div>

<?= LinkPager::widget([
    'pagination' => $dataProvider->getPagination(),
]) ?>
