<?php

/** @var $category Category */
/** @var $works Work */
/** @var $pages CPagination */

use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use yii\web\JqueryAsset;
use yii\web\View;

$this->title = 'Работы портфолио';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Портфолио',
];

Yii::app()->clientScript->registerCoreScript('jquery.ui');

if (Yii::app()->moduleManager->allowed('portfolio')) {
    $this->params['admin'][] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/admin/category/index')];
}
if (Yii::app()->moduleManager->allowed('portfolio')) {
    $this->params['admin'][] = ['label' => 'Добавить работу', 'url' => $this->createUrl('create', ['category' => $category])];
}

JqueryAsset::register(Yii::$app->view);
?>

<p class="floatright"><a href="<?= $this->createUrl('create', ['category' => $category]) ?>">Добавить</a>
</p>
<h1>Портфолио</h1>

<p id="saving" style="display:none;float:right"><img src="/images/loading.gif"></p>

<?= CHtml::beginForm($this->createUrl('index'), 'get') ?>
<p>
    Раздел: <?= CHtml::dropDownList('category', $category, ['0' => 'Все разделы'] + Category::model()->getTabList(), ['onchange' => 'this.form.submit()']) ?>
    <?= CHtml::submitButton('Выбрать') ?>
</p>
<br />
<?= CHtml::endForm() ?>

<table class="grid nomargin">
    <tr>
        <th width="50px"></th>
        <th>Заголовок</th>
        <th width="200px">Раздел</th>
        <th width="20px" title="Опубликовано">О</th>
        <th width="20px"></th>
        <th width="20px"></th>
    </tr>
</table>

<div id="listBlock">

    <?php foreach ($works as $item) :
        $editurl = $this->createUrl('update', ['id' => $item->id]);
        $delurl = $this->createUrl('delete', ['id' => $item->id]);

        $toggle_public = $this->createUrl('toggle', ['id' => $item->id, 'param' => 'public']);

        ?>

        <table id="item_<?= $item->id ?>" class="grid nomargin sortable">
            <?php if ($item->public) : ?>
            <tr>
                <?php else : ?>
            <tr class="disable">
                <?php endif; ?>

                <td width="50px" style="text-align: center">
                    <?php if ($item->image) : ?>
                        <a href="<?= $editurl ?>"><img style="width:50px;" src="<?= $item->getImageThumbUrl(50, 0) ?>" alt="<?= $item->title ?>"></a>
                    <?php endif; ?>
                </td>
                <td><a href="<?= $editurl ?>"><?= $item->title ?></a></td>
                <td width="200px" style="text-align: center">
                    <a href="<?= $editurl ?>"><?= $item->category->title ?></a></td>
                <td width="20px" style="text-align: center; padding: 0" title="Опубликовано">
                    <a class="field" href="<?= $toggle_public ?>"><?php if ($item->public) : ?>
                        <img src="/imag<?php endif; ?></a></td>
                <td width=" 20px" style="text-align: center">
                        <a href="<?= $editurl ?>"><img src="/images/admin/edit.png" width="16" height="16" alt="Править" title="Править"></a>
                </td>
                <td width="20px" style="text-align: center">
                    <a class="ajax_del" data-del="item_<?= $item->id ?>" title="Удалить материал &laquo;<?= $item->title ?>&raquo;" href="<?= $delurl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                </td>
            </tr>
        </table>

    <?php endforeach; ?>

</div>

<?php Yii::app()->controller->widget(CLinkPager::class, [
    'pages' => $pages,
]); ?>

<style>
    .ui-state-highlight {
        height: 60px;
        background: #eee;
        border: #aaa 1px dashed;
        margin: 0;
    }
</style>

<script>
<?php ob_start() ?>

jQuery(function($) {
    $(function () {
        var listBlock = $('#listBlock');
        listBlock.sortable({
            placeholder: 'ui-state-highlight',
            items: '>table',
            opacity: 0.5,
            cursor: 'move',
            axis: 'y',
            update: function () {
                $('#saving').show()
                var items = listBlock.sortable('serialize')
                $.ajax({
                    type: 'POST',
                    url: '<?= $this->createUrl('sort') ?>',
                    data: items + '&YII_CSRF_TOKEN=' + getCSRFToken(),
                    success: function () {
                        $('#saving').hide()
                    },
                    error: function (XHR) {
                        alert(XHR.responseText)
                    }
                })
            }
        })
        listBlock.disableSelection()
    })
})

<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>
