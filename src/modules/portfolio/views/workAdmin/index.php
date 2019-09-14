<?php
$this->pageTitle = 'Работы портфолио';
$this->breadcrumbs = [
    'Панель управления' => ['/admin'],
    'Портфолио',
];

Yii::app()->clientScript->registerCoreScript('jquery.ui');

if ($this->moduleAllowed('portfolio')) {
    $this->admin[] = ['label' => 'Категории', 'url' => $this->createUrl('/portfolio/categoryAdmin/index')];
}
if ($this->moduleAllowed('portfolio')) {
    $this->admin[] = ['label' => 'Добавить работу', 'url' => $this->createUrl('create', ['category' => $category])];
}

$this->info = 'Портфолио';
?>

<p class="floatright"><a href="<?php echo $this->createUrl('create', ['category' => $category]); ?>">Добавить</a>
</p>
<h1>Портфолио</h1>

<p id="saving" style="display:none;float:right"><img src="/images/loading.gif"></p>

<?php echo CHtml::beginForm($this->createUrl('index'), 'get'); ?>
<p>
    Раздел: <?php echo CHtml::dropDownList('category', $category, ['0' => 'Все разделы'] + PortfolioCategory::model()->getTabList(), ['onchange' => 'this.form.submit()']); ?>
    <?php echo CHtml::submitButton('Выбрать', ['class' => 'js_hide']); ?>
</p>
<br />
<?php echo CHtml::endForm(); ?>

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

        <table id="item_<?php echo $item->id; ?>" class="grid nomargin sortable">
            <?php if ($item->public) : ?>
            <tr>
                <?php else : ?>
            <tr class="disable">
                <?php endif; ?>

                <td width="50px" class="center">
                    <?php if ($item->image) : ?>
                        <a href="<?php echo $editurl; ?>"><img style="width:50px;" src="<?php echo $item->getImageThumbUrl(50, 0); ?>" alt="<?php echo $item->title; ?>" /></a>
                    <?php endif; ?>
                </td>
                <td><a href="<?php echo $editurl; ?>"><?php echo $item->title; ?></a></td>
                <td width="200px" class="center">
                    <a href="<?php echo $editurl; ?>"><?php echo $item->category->title; ?></a></td>
                <td width="20px" class="nopadding center" title="Опубликовано">
                    <a class="field" href="<?php echo $toggle_public; ?>"><?php if ($item->public) : ?>
                        <img src="/imag<?php endif; ?></a></td>
                <td width=" 20px" class="center">
                        <a href="<?php echo $editurl; ?>"><img src="/images/admin/edit.png" width="16" height="16" alt="Править" title="Править" /></a>
                </td>
                <td width="20px" class="center">
                    <a class="ajax_del" data-del="item_<?php echo $item->id; ?>" title="Удалить материал &laquo;<?php echo $item->title; ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                </td>
            </tr>
        </table>

    <?php endforeach; ?>

</div>

<?php $this->widget(\CLinkPager::class, [
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
jQuery(function () {
    jQuery('#listBlock').sortable({
        placeholder: 'ui-state-highlight',
        items: '>table',
        opacity: 0.5,
        cursor: 'move',
        axis: 'y',
        update: function (event, ui) {
            jQuery('#saving').show()
            var items = $('#listBlock').sortable('serialize')
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('sort'); ?>',
                data: items + '&YII_CSRF_TOKEN=' + getCSRFToken(),
                success: function (data) {
                    $('#saving').hide()
                },
                error: function (XHR) {
                    alert(XHR.responseText)
                }
            })
        }
    })
    jQuery('#listBlock').disableSelection()
})
</script>
