<?php
/** @var $this \yii\web\View */

use app\assets\ColorboxAsset;
use app\modules\contact\models\Contact;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

/** @var $model Contact */
/** @var $htmlroot string */
/** @var $root string */
/** @var $upload_count integer */

$this->title = 'Файловый менеджер';
$this->params['breadcrumbs'] = [
    'Файловый менеджер',
];

if (Yii::$app->moduleManager->allowed('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
}

JqueryAsset::register($this);
?>

<h1>Файловый менеджер</h1>

<?php
$folders = explode('/', $path);
$nav = '';
?>

<h3>
    <a href="<?= Url::to(['index']) ?>"><?= $htmlroot ?></a>
    <?php foreach ($folders as $folder) : ?>
        <?php $nav .= $nav ? '/' . $folder : $folder; ?>

        <?php if ($nav) :
            ?>/
            <a href="<?= Url::to(['index', 'path' => $nav]) ?>"><?= $folder ?></a><?php
        endif; ?>

    <?php endforeach; ?>
</h3>

<?php
$dir = Yii::$app->file->set($root . '/' . $path);
$renameIcon = CHtml::image('/images/admin/code.png', 'Переименовать', ['title' => 'Переименовать']);
?>

<?= Html::beginForm(Url::to(['process', 'path' => $path])) ?>

<table class="grid" style="margin-bottom:20px !important;">

    <tr>
        <th style="width:24px;padding:0 !important;">
            <?= Html::checkBox('checkall', false, ['class' => 'allfiles_checkbox']) ?>
        </th>
        <th>Файл</th>
        <th style="width:70px">Размер</th>
        <th style="width:140px">Изменён</th>
        <th style="width:16px"></th>
    </tr>

    <?php if ($contents = $dir->getContents()) : ?>
        <?php foreach ($contents as $item) : ?>
            <?php
            $file = Yii::$app->file->set($item);
            if ($file->getBasename() === '.htaccess') {
                continue;
            }
            ?>

            <?php if ($file->getIsDir()) : ?>
                <?php $delurl = Url::to(['delete', 'name' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>

                <tr id="item_<?= md5($file->getBasename()) ?>">
                    <td style="text-align: center">
                        <?php //echo yii\helpers\Html::checkBox('del_'.md5($file->getBasename()), false, array('class'=>'folder_checkbox')); ?>
                    </td>
                    <td>
                        <a class="renameLink floatright" href="#" onclick="renameBox('<?= $file->getBasename() ?>'); return false;"><?= $renameIcon ?></a>
                        <img src="/images/admin/foldericon.jpg" alt="">
                        <a href="<?= Url::to(['index', 'path' => ($path ? $path . '/' : '') . $file->getBasename()]) ?>"><?= $file->getBasename() ?></a>
                    </td>
                    <td></td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $file->getTimeModified()) ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?= md5($file->getBasename()) ?>" title="Удалить директорию &laquo;<?= $file->getBasename() ?>&raquo;" href="<?= $delurl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php else : ?>
                <?php $delurl = Url::to(['delete', 'name' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>

                <tr id="item_<?= md5($file->getBasename()) ?>">
                    <td style="text-align: center">
                        <?= Html::checkBox('del_' . md5($file->getBasename()), false, ['class' => 'file_checkbox']) ?>
                    </td>
                    <td>
                        <a class="renameLink floatright" href="#" onclick="renameBox('<?= $file->getBasename() ?>')"><?= $renameIcon ?></a>
                        <img src="/images/admin/fileicon.jpg">
                        <a href="<?= $htmlroot . '/' . ($path ? $path . '/' : '') . $file->getBasename() ?>"><?= $file->getBasename() ?></a>
                    </td>
                    <td style="text-align: center">
                        <?= $file->getSize() ?>
                    </td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $file->getTimeModified()) ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?= md5($file->getBasename()) ?>" title="Удалить файл &laquo;<?= $file->getBasename() ?>&raquo;" href="<?= $delurl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>

</table>

<p>Отмеченные
    <?= Html::dropDownList('action', '', [
        'del' => 'удалить',
    ]) ?>
    <?= Html::submitButton('OK') ?>
</p>

<script>
<?php ob_start() ?>

jQuery(function ($) {
    $('.allfiles_checkbox').click(function () {
        $('.file_checkbox').attr('checked', !!$(this).attr('checked'));
    });
});

<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>

<?= Html::endForm() ?>

<hr />

<?= Html::beginForm() ?>

<?= Html::textInput('foldername', '', ['size' => 30]) ?>
<?= Html::submitButton('Создать директорию') ?>

<?= Html::endForm() ?>

<hr />

<div class="upload-alternate">
    <?= Html::beginForm('', 'post', [
        'enctype' => 'multipart/form-data'
    ]) ?>

    <p>
        <?php for ($i = 1; $i <= $upload_count; $i++) : ?>
            <?= Html::fileInput('file_' . $i) ?><br />
        <?php endfor; ?>
    </p>
    <?= Html::submitButton('Загрузить файлы') ?>

    <?= Html::endForm() ?>
</div>

<?php ColorboxAsset::register($this) ?>

<div style="display:none">
    <p><a id="renameLink" href="#rename"></a></p>
    <div id="rename" class="form">
        <?= Html::beginForm(Url::to(['rename', 'path' => Yii::$app->request->get('path')])) ?>
        <?= Html::hiddenInput('name', '', ['id' => 'sourceName']) ?>
        <div class="row">
            <?= Html::textInput('to', '', ['id' => 'destName', 'size' => 24]) ?>
        </div>
        <div class="row buttons">
            <?= Html::submitButton('Переименовать') ?>
            <?php echo yii\helpers\Html::resetButton('Отмена', ['onclick' => 'jQuery.colorbox.close(); return false;']); ?>
        </div>
        <?= Html::endForm() ?>
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

<?php $this->registerJs(ob_get_clean(), View::POS_END); ?>
</script>
