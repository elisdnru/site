<?php declare(strict_types=1);

use app\components\Csrf;
use app\extensions\file\File;
use app\modules\file\forms\admin\DirectoryForm;
use app\modules\file\forms\admin\UploadForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 * @var File[] $items
 * @var string $htmlRoot
 * @var string $root
 * @var string $path
 * @var DirectoryForm $directoryForm
 * @var UploadForm $uploadForm
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
    <a href="<?= Url::to(['index']); ?>"><?= $htmlRoot; ?></a>
    <?php foreach ($folders as $folder): ?>
        <?php $nav .= $nav ? '/' . $folder : $folder; ?>

        <?php if ($nav) :
            ?>/
            <a href="<?= Url::to(['index', 'path' => $nav]); ?>"><?= $folder; ?></a><?php
        endif; ?>

    <?php endforeach; ?>
</h3>

<?php
$renameIcon = Html::img('/images/admin/code.png', ['title' => 'Переименовать']);
?>

<table class="grid" style="margin-bottom:20px !important;">

    <tr>
        <th>Файл</th>
        <th style="width:70px">Размер</th>
        <th style="width:140px">Изменён</th>
        <th style="width:16px"></th>
    </tr>

    <?php if ($items): ?>
        <?php foreach ($items as $item): ?>
            <?php $delUrl = Url::to(['delete', 'path' => $path, 'name' => $item->getBasename() ?: '']); ?>
            <?php $renameUrl = Url::to(['rename', 'path' => $path, 'name' => $item->getBasename() ?: '']); ?>

            <?php if ($item->getIsDir()): ?>
                <tr id="item_<?= md5($item->getBasename() ?: ''); ?>">
                    <td>
                        <a class="float-right" href="<?= Html::encode($renameUrl); ?>"><?= $renameIcon; ?></a>
                        <img src="/images/admin/foldericon.jpg" alt="">
                        <a href="<?= Url::to(['index', 'path' => ($path ? $path . '/' : '') . ($item->getBasename() ?: '')]); ?>"><?= $item->getBasename(); ?></a>
                    </td>
                    <td></td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $item->getTimeModified() ?: 0); ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax-del" data-del="item_<?= md5($item->getBasename() ?: ''); ?>" title="Удалить директорию &laquo;<?= $item->getBasename(); ?>&raquo;" href="<?= $delUrl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php else: ?>
                <tr id="item-<?= md5($item->getBasename() ?: ''); ?>">
                    <td>
                        <a class="float-right" href="<?= Html::encode($renameUrl); ?>"><?= $renameIcon; ?></a>
                        <img src="/images/admin/fileicon.jpg">
                        <a href="<?= $htmlRoot . '/' . ($path ? $path . '/' : '') . ($item->getBasename() ?: ''); ?>"><?= $item->getBasename(); ?></a>
                    </td>
                    <td style="text-align: center">
                        <?= (string)$item->getSize(); ?>
                    </td>
                    <td style="text-align: center">
                        <?= date('Y-m-d h:i:s', $item->getTimeModified() ?: 0); ?>
                    </td>
                    <td style="text-align: center">
                        <a class="ajax-del" data-del="item-<?= md5($item->getBasename() ?: ''); ?>" title="Удалить файл &laquo;<?= $item->getBasename(); ?>&raquo;" href="<?= $delUrl; ?>"><img src="/images/admin/del.png" width="16" height="16" alt="Удалить" title="Удалить"></a>
                    </td>
                </tr>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php endif; ?>

</table>

<div class="form">
    <form action="" method="post">
        <?= Csrf::hiddenInput(); ?>
        <fieldset>
            <div class="row<?= $directoryForm->hasErrors('name') ? ' error' : ''; ?>">
                <?= Html::activeTextInput($directoryForm, 'name', ['size' => 60, 'maxlength' => 255]); ?><br />
                <?= Html::error($directoryForm, 'name', ['class' => 'error-message']); ?>
            </div>
            <div class="row buttons">
                <?= Html::submitButton('Создать директорию'); ?>
            </div>
        </fieldset>
    </form>
</div>

<div class="form">
    <form action="" method="post" enctype="multipart/form-data">
        <?= Csrf::hiddenInput(); ?>
        <fieldset>
            <div class="row<?= $uploadForm->hasErrors('files') ? ' error' : ''; ?>">
                <?= Html::activeFileInput($uploadForm, 'files'); ?><br />
                <?= Html::error($uploadForm, 'files', ['class' => 'error-message']); ?>
            </div>
            <div class="row buttons">
                <?= Html::submitButton('Загрузить файлы'); ?>
            </div>
        </fieldset>
    </form>
</div>
