<?php

declare(strict_types=1);

namespace app\modules\file\controllers\admin;

use app\components\AdminController;
use app\components\FilenameEscaper;
use app\extensions\file\File;
use app\modules\file\forms\admin\DirectoryForm;
use app\modules\file\forms\admin\RenameForm;
use app\modules\file\forms\admin\UploadForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

final class FileController extends AdminController
{
    private const UPLOAD_PATH = 'upload/media';

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'process' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex(Request $request, File $fileHandler, string $path = ''): Response|string
    {
        $path = FilenameEscaper::escapePath($path);

        $root = ((string)Yii::getAlias('@webroot')) . '/' . $this->getFileDir();

        if (!file_exists($root)) {
            FileHelper::createDirectory($root, 0754);
        }

        $currentPath = $root . ($path ? '/' . $path : '');

        if (!file_exists($currentPath)) {
            throw new NotFoundHttpException();
        }

        $uploadForm = new UploadForm();

        if ($uploadForm->load((array)$request->post())) {
            $uploadForm->files = UploadedFile::getInstances($uploadForm, 'files');
            if ($uploadForm->validate()) {
                foreach ($uploadForm->files as $file) {
                    $file->saveAs($currentPath . '/' . FilenameEscaper::escapeFile($file->name));
                }
                return $this->refresh();
            }
        }

        $directoryForm = new DirectoryForm();

        if ($directoryForm->load((array)$request->post()) && $directoryForm->validate()) {
            FileHelper::createDirectory($currentPath . '/' . $directoryForm->name, 0754);
        }

        $items = array_map(
            static fn (string $path): File => $fileHandler->set($path),
            ArrayHelper::merge(
                FileHelper::findDirectories($root . '/' . $path, ['recursive' => false]),
                FileHelper::findFiles($root . '/' . $path, ['recursive' => false])
            )
        );

        $htmlRoot = '/' . $this->getFileDir();

        return $this->render('index', [
            'htmlRoot' => $htmlRoot,
            'root' => $root,
            'path' => $path,
            'items' => $items,
            'directoryForm' => $directoryForm,
            'uploadForm' => $uploadForm,
        ]);
    }

    public function actionDelete(string $path, string $name, Request $request, File $fileHandler): ?Response
    {
        $path = FilenameEscaper::escapeFile($path);
        $name = FilenameEscaper::escapeFile($name);

        $file = $fileHandler->set($this->getFileDir() . ($path ? '/' . $path : '') . '/' . $name, true);

        if (!$file->delete()) {
            throw new BadRequestHttpException('Ошибка удаления');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index']);
        }

        return null;
    }

    public function actionRename(string $path, string $name, Request $request, File $fileHandler): Response|string
    {
        $path = FilenameEscaper::escapePath($path);
        $name = FilenameEscaper::escapeFile($name);

        $form = new RenameForm();
        $form->name = $name;

        if ($form->load((array)$request->post()) && $form->validate()) {
            $file = $fileHandler->set($this->getFileDir() . ($path ? '/' . $path : '') . '/' . $name, true);

            $to = FilenameEscaper::escapeFile($form->name);

            if (!$file->rename($this->getFileDir() . '/' . ($path ? '/' . $path : '') . '/' . $to)) {
                throw new BadRequestHttpException('Ошибка переименования');
            }

            if (!$request->getIsAjax()) {
                return $this->redirect(['index', 'path' => $path]);
            }
        }

        return $this->render('rename', [
            'model' => $form,
            'path' => $path,
        ]);
    }

    private function getFileDir(): string
    {
        return self::UPLOAD_PATH;
    }
}
