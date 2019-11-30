<?php
use app\components\NumberHelper;
use app\modules\search\components\SearchHighlighter;
use app\modules\search\widgets\SearchFormWidget;
use app\modules\user\models\Access;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;

/** @var $this \yii\web\View|\app\components\widgets\InlineWidgetsBehavior */
/** @var $dataProvider ActiveDataProvider */
/** @var $query CActiveRecord */

$this->title = 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam);

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Поиск по сайту' . NumberHelper::pageString($dataProvider->getPagination()->pageParam),
]);

$this->params['breadcrumbs'] = [
    'Поиск по сайту',
];

if (Yii::$app->user->can(Access::CONTROL)) {
    if (Yii::$app->moduleManager->allowed('blog')) {
        $this->params['admin'][] = ['label' => 'Записи', 'url' => ['/blog/admin/post']];
    }
    if (Yii::$app->moduleManager->allowed('page')) {
        $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page']];
    }
}
?>

<h1>Поиск по сайту</h1>

<?= SearchFormWidget::widget() ?>

<div class="items">
    <?php foreach ($dataProvider->getModels() as $model) : ?>
        <article class="entry list">
            <header>
                <h2>
                    <a href="<?= $model->material->url ?>"><?= SearchHighlighter::getFragment(strip_tags($model->title), $query) ?></a>
                </h2>
                <?php if ($model->material->hasAttribute('image')) : ?>
                    <?php
                    $properties = array_filter([
                        'width' => $model->material->image_width,
                        'height' => $model->material->image_height,
                    ]);
                    ?>
                    <p class="thumb">
                        <a href="<?= $model->material->url ?>"><?= CHtml::image($model->material->getImageThumbUrl(), '', $properties) ?></a>
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
