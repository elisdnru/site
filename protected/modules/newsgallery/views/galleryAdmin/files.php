<?php
/* @var $this DAdminController */
/* @var $model NewsGallery */
/* @var $htmlroot string */
/* @var $root string */
/* @var $upload_count int */

$this->pageTitle='Менеджер фотографий';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Фотогалереи'=>array('index'),
    'Менеджер фотографий',
);

$this->admin[] = array('label'=>'Фотогалереи', 'url'=>$this->createUrl('index'));
$this->admin[] = array('label'=>'Редактировать заголовок', 'url'=>$this->createUrl('update', array('id'=>$model->id)));
$this->admin[] = array('label'=>'Добавить фотогалерею', 'url'=>$this->createUrl('create'));

$this->info = 'Чтобы скопировать адрес ссылки на файл щёлкните по нему правой кнопкой мыши';

?>

<h1>Фотографии галереи &laquo;<?php echo $model->title; ?>&raquo;</h1>

<p>Превью всех изображений: <a class="confirm" title="Перегенерировать превью у всех изображений" href="<?php echo $this->createUrl('regenerate', array('id'=>$model->id)); ?>">перегенерировать</a> | <a class="confirm" title="Удалить превью у всех изображений" href="<?php echo $this->createUrl('clearthumbs', array('id'=>$model->id)); ?>">удалить</a></p>

<?php if(Yii::app()->user->hasFlash('filemanager')): ?>

<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('filemanager'); ?>
</div>

<?php endif; ?>

<?php
$dir = Yii::app()->file->set($root.'/'.$path);
$renameIcon = CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/code.png', 'Переименовать', array('title'=>'Переименовать'));
?>

<?php echo CHtml::beginForm($this->createUrl('process', array('id'=>$model->id))); ?>

    <table class="grid" style="margin-bottom:20px !important;">

        <tr>
            <th style="width:24px;padding:0 !important;">
                <?php echo CHtml::checkBox('checkall', false, array('class'=>'allfiles_checkbox')); ?>
            </th>
            <th style="width:50px;padding:0 !important;"></th>
            <th>Файл</th>
            <th style="width:70px">Размер</th>
            <th style="width:140px">Изменён</th>
            <th style="width:16px"></th>
        </tr>

        <?php if ($dir->contents) : ?>

            <?php foreach ($dir->contents as $item) : ?>

                <?php
                    $file = Yii::app()->file->set($item);
                    if ($file->basename == '.htaccess') continue;
                    if (preg_match('|_prev$|', $file->filename, $t)) continue;
                ?>

                <?php if (!$file->isDir): ?>

                    <?php $delurl = $this->createUrl('delfile', array('id'=>$model->id, 'name'=>$file->basename)); ?>

                    <tr id="item_<?php echo md5($file->basename); ?>">
                        <td class="center">
                            <?php echo CHtml::checkBox('del_'.md5($file->basename), false, array('class'=>'file_checkbox')); ?>
                        </td>
                        <td>
                            <a target="_blank" href="<?php echo $htmlroot . '/' . $path . '/' . $file->basename; ?>"><img src="<?php echo  $htmlroot . '/' . $path . '/' . $file->filename . '_prev.' . $file->extension; ?>" style="width:50px" /></a>
                        </td>
                        <td>
                            <a class="renameLink floatright" href="#" onclick="rename('<?php echo $file->basename; ?>'); return false;"><?php echo $renameIcon; ?></a>
                            <img src="/core/images/admin/fileicon.jpg" />
                            <a href="<?php echo $htmlroot . '/' . $path . '/' . $file->basename; ?>"><?php echo $file->basename; ?></a>
                        </td>
                        <td class="center">
                            <?php echo $file->size; ?>
                        </td>
                        <td class="center">
                            <?php echo date('Y-m-d h:i:s', $file->timeModified); ?>
                        </td>
                        <td class="center">
                            <a class="ajax_del" data-del="item_<?php echo md5($file->basename); ?>" title="Удалить файл &laquo;<?php echo $file->basename; ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/core/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                        </td>
                    </tr>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </table>

    <p>Отмеченные
    <?php echo CHtml::dropDownList('action', '', array(
        'del'=>'удалить',
    ));  ?>
    <?php echo CHtml::submitButton('OK'); ?>
    </p>

    <script type="text/javascript">
        $('.allfiles_checkbox').click(function(){
            $('.file_checkbox').attr('checked', $(this).attr('checked') ? true : false);
        });
    </script>

<?php echo CHtml::endForm(); ?>

<hr />

<div class="upload-box">

    <p id="status-message">Выберите файлы для загрузки (щелкнув по кнопке):</p>

    <?php $this->widget('file.extensions.uploadify.MUploadify',array(
        'name'=>'Filedata',
        'script' => $this->createUrl('upload', array('id'=>$model->id)),
        'checkScript' => $this->createUrl('checkexists', array('id'=>$model->id)),
        'multi' => true,
        'auto'  => true,
        'removeCompleted' => true,
        'fileTypeExts' => '*.jpg;*.gif;*.png',
        'fileTypeDesc' => 'Image Files (.JPG, .GIF, .PNG)',
        'onAllComplete' => "js:function (event, data) {
            window.location.reload();
        }",
    )); ?>

    <hr />
</div>

<div class="upload-alternate">
<?php echo CHtml::beginForm('', 'post',array(
    'enctype'=>'multipart/form-data'
)); ?>

<p>Классический загрузчик:</p>

<p>
<?php for ($i=1; $i <= $upload_count; $i++): ?>
<?php echo CHtml::fileField('file_'.$i, '', array('size'=>31)); ?><br />
<?php endfor; ?>
</p>
<?php echo CHtml::submitButton('Загрузить файлы'); ?>

<?php echo CHtml::endForm(); ?>
</div>

<script type="text/javascript">
//<![CDATA[
    $('.upload-box').show();
    $('.upload-box').css('margin',0);
//]]>
</script>

<?php $this->widget('colorbox.widgets.ColorboxWidget'); ?>

<div style="display:none">
    <p><a id="renameLink" href="#rename"></a></p>
    <div id="rename" class="form">
        <?php echo CHtml::beginForm($this->createUrl('renamefile', array('id'=>Yii::app()->request->getQuery('id')))); ?>
        <?php echo CHtml::hiddenField('name', '', array('id'=>'sourceName')); ?>
        <div class="row">
            <?php echo CHtml::textField('to', '', array('id'=>'destName', 'size'=>24)); ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Переименовать'); ?>
            <?php echo CHtml::resetButton('Отмена', array('onclick'=>'jQuery.colorbox.close(); return false;')); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>

<script type="text/javascript">
//<![CDATA[
    jQuery('#renameLink').colorbox({
        'initialWidth' : 186,
        'initialHeight' : 67,
        inline: true,
        'opacity' : 0
    });

    function rename($name)
    {
        jQuery('#sourceName').val($name);
        jQuery('#destName').val($name);
        jQuery('#renameLink').click();
    }
//]]>
</script>