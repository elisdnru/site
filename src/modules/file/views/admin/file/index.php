<?php
/** @var $this AdminController */

use app\modules\contact\models\Contact;
use app\components\AdminController;
use yii\web\JqueryAsset;

/** @var $model Contact */
/** @var $htmlroot string */
/** @var $root string */
/** @var $upload_count integer */

$this->title = 'Файловый менеджер';
$this->params['breadcrumbs'] = [
    'Панель управления' => ['/admin'],
    'Файловый менеджер',
];

if (Yii::app()->moduleManager->allowed('page')) {
    $this->admin[] = ['label' => 'Страницы', 'url' => $this->createUrl('/page/admin/page/index')];
}

JqueryAsset::register(Yii::$app->view);
?>

<h1>Файловый менеджер</h1>

<?php if (Yii::app()->user->hasFlash('filemanager')) : ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('filemanager'); ?>
    </div>

<?php endif; ?>

<?php
$folders = explode('/', $path);
$nav = '';
?>

<h3>
    <a href="<?php echo $this->createUrl('index'); ?>"><?php echo $htmlroot; ?></a>
    <?php foreach ($folders as $folder) : ?>
        <?php $nav .= $nav ? '/' . $folder : $folder; ?>

        <?php if ($nav) :
            ?>/
            <a href="<?php echo $this->createUrl('index', ['path' => $nav]); ?>"><?php echo $folder; ?></a><?php
        endif; ?>

    <?php endforeach; ?>
</h3>

<?php
$dir = Yii::$app->file->set($root . '/' . $path);
$renameIcon = CHtml::image('/images/admin/code.png', 'Переименовать', ['title' => 'Переименовать']);
?>

<?php echo CHtml::beginForm($this->createUrl('process', ['path' => $path])); ?>

<table class="grid" style="margin-bottom:20px !important;">

    <tr>
        <th style="width:24px;padding:0 !important;">
            <?php echo CHtml::checkBox('checkall', false, ['class' => 'allfiles_checkbox']); ?>
        </th>
        <th>Файл</th>
        <th style="width:70px">Размер</th>
        <th style="width:140px">Изменён</th>
        <th style="width:16px"></th>
    </tr>

    <?php if ($contents = $dir->getContents()): ?>
        <?php foreach ($contents as $item) : ?>
            <?php
            $file = Yii::$app->file->set($item);
            if ($file->getBasename() === '.htaccess') {
                continue;
            }
            ?>

            <?php if ($file->getIsDir()) : ?>
                <?php $delurl = $this->createUrl('delete', ['name' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>

                <tr id="item_<?php echo md5($file->getBasename()); ?>">
                    <td style="text-align: center">
                        <?php //echo CHtml::checkBox('del_'.md5($file->getBasename()), false, array('class'=>'folder_checkbox')); ?>
                    </td>
                    <td>
                        <a class="renameLink floatright" href="#" onclick="renameBox('<?php echo $file->getBasename(); ?>'); return false;"><?php echo $renameIcon; ?></a>
                        <img src="/images/admin/foldericon.jpg" alt="" />
                        <a href="<?php echo $this->createUrl('index', ['path' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>"><?php echo $file->getBasename(); ?></a>
                    </td>
                    <td></td>
                    <td style="text-align: center">
                        <?php echo date('Y-m-d h:i:s', $file->getTimeModified()); ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?php echo md5($file->getBasename()); ?>" title="Удалить директорию &laquo;<?php echo $file->getBasename(); ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                    </td>
                </tr>

            <?php else : ?>
                <?php $delurl = $this->createUrl('delete', ['name' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>

                <tr id="item_<?php echo md5($file->getBasename()); ?>">
                    <td style="text-align: center">
                        <?php echo CHtml::checkBox('del_' . md5($file->getBasename()), false, ['class' => 'file_checkbox']); ?>
                    </td>
                    <td>
                        <a class="renameLink floatright" href="#" onclick="renameBox('<?php echo $file->getBasename(); ?>')"><?php echo $renameIcon; ?></a>
                        <img src="/images/admin/fileicon.jpg" />
                        <a href="<?php echo $htmlroot . '/' . ($path ? $path . '/' : '') . $file->getBasename(); ?>"><?php echo $file->getBasename(); ?></a>
                    </td>
                    <td style="text-align: center">
                        <?php echo $file->getSize(); ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo date('Y-m-d h:i:s', $file->getTimeModified()); ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?php echo md5($file->getBasename()); ?>" title="Удалить файл &laquo;<?php echo $file->getBasename(); ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                    </td>
                </tr>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>

</table>

<p>Отмеченные
    <?php echo CHtml::dropDownList('action', '', [
        'del' => 'удалить',
    ]); ?>
    <?php echo CHtml::submitButton('OK'); ?>
</p>

<script>
<?php ob_start() ?>

jQuery(function ($) {
    $('.allfiles_checkbox').click(function () {
        $('.file_checkbox').attr('checked', !!$(this).attr('checked'))
    })
})

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>

<?php echo CHtml::endForm(); ?>

<hr />

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::textField('foldername', '', ['size' => 30]); ?>
<?php echo CHtml::submitButton('Создать директорию'); ?>

<?php echo CHtml::endForm(); ?>

<hr />

<div class="upload-alternate">
    <?php echo CHtml::beginForm('', 'post', [
        'enctype' => 'multipart/form-data'
    ]); ?>

    <p>
        <?php for ($i = 1; $i <= $upload_count; $i++) : ?>
            <?php echo CHtml::fileField('file_' . $i); ?><br />
        <?php endfor; ?>
    </p>
    <?php echo CHtml::submitButton('Загрузить файлы'); ?>

    <?php echo CHtml::endForm(); ?>
</div>

<?php $this->widget(\app\components\widgets\ColorboxWidget::class); ?>

<div style="display:none">
    <p><a id="renameLink" href="#rename"></a></p>
    <div id="rename" class="form">
        <?php echo CHtml::beginForm($this->createUrl('rename', ['path' => Yii::app()->request->getQuery('path')])); ?>
        <?php echo CHtml::hiddenField('name', '', ['id' => 'sourceName']); ?>
        <div class="row">
            <?php echo CHtml::textField('to', '', ['id' => 'destName', 'size' => 24]); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Переименовать'); ?>
            <?php echo CHtml::resetButton('Отмена', ['onclick' => 'jQuery.colorbox.close(); return false;']); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>

<script>
<?php ob_start() ?>

jQuery(function($) {
    $('#renameLink').colorbox({
        'initialWidth': 186,
        'initialHeight': 67,
        inline: true,
        'opacity': 0
    })
});

function renameBox($name) {
    jQuery('#sourceName').val($name)
    jQuery('#destName').val($name)
    jQuery('#renameLink').click()
}

<?php Yii::app()->clientScript->registerScript(__FILE__ . __LINE__, ob_get_clean(), CClientScript::POS_END); ?>
</script>
