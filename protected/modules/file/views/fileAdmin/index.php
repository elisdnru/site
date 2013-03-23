<?php
/* @var $this DAdminController */
/* @var $model Contact */
/* @var $htmlroot string */
/* @var $root string */
/* @var $upload_count integer */

$this->pageTitle='Файловый менеджер';
$this->breadcrumbs=array(
    'Панель управления'=>array('/admin'),
    'Файловый менеджер',
);

if ($this->moduleAllowed('new')) $this->admin[] = array('label'=>'Новости', 'url'=>$this->createUrl('/new/newAdmin/index'));
if ($this->moduleAllowed('page')) $this->admin[] = array('label'=>'Страницы', 'url'=>$this->createUrl('/page/pageAdmin/index'));

$this->info = 'Чтобы скопировать адрес ссылки на файл щёлкните по нему правой кнопкой мыши';

?>

<h1>Файловый менеджер</h1>

<?php if(Yii::app()->user->hasFlash('filemanager')): ?>

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

    <?php $nav .= $nav ? '/'.$folder : $folder; ?>

    <?php if ($nav): ?>/ <a href="<?php echo $this->createUrl('index', array('path'=>$nav)); ?>"><?php echo $folder; ?></a><?php endif; ?>

<?php endforeach; ?>
</h3>

<?php
$dir = Yii::app()->file->set($root.'/'.$path);
$renameIcon = CHtml::image(Yii::app()->request->baseUrl . '/core/images/admin/code.png', 'Переименовать', array('title'=>'Переименовать'));
?>

<?php echo CHtml::beginForm($this->createUrl('process', array('path'=>$path))); ?>

    <table class="grid" style="margin-bottom:20px !important;">

        <tr>
            <th style="width:24px;padding:0 !important;">
                <?php echo CHtml::checkBox('checkall', false, array('class'=>'allfiles_checkbox')); ?>
            </th>
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
                ?>

                <?php if ($file->isDir): ?>

                    <?php $delurl = $this->createUrl('delete', array('name'=>($path ? $path.'/' : '').$file->basename)); ?>

                    <tr id="item_<?php echo md5($file->basename); ?>">
                        <td class="center">
                            <?php //echo CHtml::checkBox('del_'.md5($file->basename), false, array('class'=>'folder_checkbox')); ?>
                        </td>
                        <td>
                            <a class="renameLink floatright" href="#" onclick="rename('<?php echo $file->basename; ?>'); return false;"><?php echo $renameIcon; ?></a>
                            <img src="/core/images/admin/foldericon.jpg" />
                            <a href="<?php echo $this->createUrl('index', array('path'=>($path ? $path.'/' : '').$file->basename)); ?>"><?php echo $file->basename; ?></a>
                        </td>
                        <td></td>
                        <td class="center">
                        <?php echo date('Y-m-d h:i:s', $file->timeModified); ?>
                        </td>
                        <td class="center">
                            <a class="ajax_del" data-del="item_<?php echo md5($file->basename); ?>" title="Удалить директорию &laquo;<?php echo $file->basename; ?>&raquo;" href="<?php echo $delurl; ?>"><img src="/core/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить" /></a>
                        </td>
                    </tr>

                <?php else : ?>

                    <?php $delurl = $this->createUrl('delete', array('name'=>($path ? $path.'/' : '').$file->basename)); ?>

                    <tr id="item_<?php echo md5($file->basename); ?>">
                        <td class="center">
                            <?php echo CHtml::checkBox('del_'.md5($file->basename), false, array('class'=>'file_checkbox')); ?>
                        </td>
                        <td>
                            <a class="renameLink floatright" href="#" onclick="rename('<?php echo $file->basename; ?>')"><?php echo $renameIcon; ?></a>
                            <img src="/core/images/admin/fileicon.jpg" />
                            <a href="<?php echo $htmlroot.'/'.($path ? $path.'/' : '').$file->basename; ?>"><?php echo $file->basename; ?></a>
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

<?php echo CHtml::beginForm(''); ?>

<?php echo CHtml::textField('foldername', '', array('size'=>30)); ?>
<?php echo CHtml::submitButton('Создать директорию'); ?>

<?php echo CHtml::endForm(); ?>

<hr />

<?php $baseurl = Yii::app()->request->baseUrl; ?>

<div class="upload-box">

    <p id="status-message">Выберите файлы для загрузки (щелкнув по кнопке):</p>

    <?php $this->widget('file.extensions.uploadify.MUploadify',array(
        'name'=>'Filedata',
        'script' => $this->createUrl('upload', array('path'=>$path)),
        'checkScript' => $this->createUrl('checkexists', array('path'=>$path)),
        'multi' => true,
        'auto'  => true,
        'removeCompleted' => true,
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
        <?php echo CHtml::beginForm($this->createUrl('rename', array('path'=>Yii::app()->request->getQuery('path')))); ?>
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