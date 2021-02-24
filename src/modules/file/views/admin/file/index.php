<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var File $model
 * @var string $htmlRoot
 * @var string $root
 * @var string $path
 * @var integer $uploadCount
 */

$this->title = 'Файловый менеджер';
$this->params['breadcrumbs'] = [
    'Файловый менеджер',
];

if (Yii::$app->moduleAdminAccess->isGranted('page')) {
    $this->params['admin'][] = ['label' => 'Страницы', 'url' => ['/page/admin/page/index']];
    $this->params['admin'][] = ['label' => 'Лендинги', 'url' => ['/landing/admin/landing/index']];
}
?>

<h1>Файловый менеджер</h1>

<?php
$folders = explode('/', $path);
$nav = '';
?>

<h3>
    <a href="<?= Url::to(['index']) ?>"><?= $htmlRoot ?></a>
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
$renameIcon = Html::img('/images/admin/code.png', ['title' => 'Переименовать']);
?>

<table class="grid" style="margin-bottom:20px !important;">

    <tr>
        <th>Файл</th>
        <th style="width:70px">Размер</th>
        <th style="width:140px">Изменён</th>
        <th style="width:16px"></th>
    </tr>

    <?php if ($contents = $dir->getContents()) : ?>
        <?php foreach ($contents as $item) : ?>
            <?php $file = Yii::$app->file->set($item); ?>
            <?php $delUrl = Url::to(['delete', 'name' => ($path ? $path . '/' : '') . $file->getBasename()]); ?>
            <?php $renameUrl = Url::to(['rename', 'path' => $path, 'name' => $file->getBasename()]); ?>

            <?php if ($file->getIsDir()) : ?>
                <tr id="item_<?= md5($file->getBasename()) ?>">
                    <td>
                        <a class="floatright" href="<?= Html::encode($renameUrl) ?>"><?= $renameIcon ?></a>
                        <img src="/images/admin/foldericon.jpg" alt="">
                        <a href="<?= Url::to(['index', 'path' => ($path ? $path . '/' : '') . $file->getBasename()]) ?>"><?= $file->getBasename() ?></a>
                    </td>
                    <td></td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $file->getTimeModified()) ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?= md5($file->getBasename()) ?>" title="Удалить директорию &laquo;<?= $file->getBasename() ?>&raquo;" href="<?= $delUrl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php else : ?>
                <tr id="item_<?= md5($file->getBasename()) ?>">
                    <td>
                        <a class="floatright" href="<?= Html::encode($renameUrl) ?>"><?= $renameIcon ?></a>
                        <img src="/images/admin/fileicon.jpg">
                        <a href="<?= $htmlRoot . '/' . ($path ? $path . '/' : '') . $file->getBasename() ?>"><?= $file->getBasename() ?></a>
                    </td>
                    <td style="text-align: center">
                        <?= $file->getSize() ?>
                    </td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $file->getTimeModified()) ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax_del" data-del="item_<?= md5($file->getBasename()) ?>" title="Удалить файл &laquo;<?= $file->getBasename() ?>&raquo;" href="<?= $delUrl ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>

</table>

<hr />

<?= Html::beginForm() ?>

<?= Html::textInput('folderName', '', ['size' => 30]) ?>
<?= Html::submitButton('Создать директорию') ?>

<?= Html::endForm() ?>

<hr />

<div class="upload-alternate">
    <?= Html::beginForm('', 'post', [
        'enctype' => 'multipart/form-data'
    ]) ?>

    <p>
        <?php for ($i = 1; $i <= $uploadCount; $i++) : ?>
            <?= Html::fileInput('file_' . $i) ?><br />
        <?php endfor; ?>
    </p>
    <?= Html::submitButton('Загрузить файлы') ?>

    <?= Html::endForm() ?>
</div>
