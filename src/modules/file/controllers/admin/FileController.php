<?php

declare(strict_types=1);

namespace app\modules\file\controllers\admin;

use app\components\AdminController;
use app\components\FilenameEscaper;
use app\components\Slugger;
use app\extensions\file\File;
use app\modules\file\forms\DirectoryForm;
use app\modules\file\forms\RenameForm;
use app\modules\file\forms\UploadForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\UploadedFile;

final class FileController extends AdminController
{
    private const UPLOAD_COUNT = 7;
    private const UPLOAD_PATH = 'upload/media';

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'process' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex(Request $request, File $fileHandler, string $path = ''): Response|string
    {
        $path = FilenameEscaper::escape($path);

        $root = ((string)Yii::getAlias('@webroot')) . '/' . $this->getFileDir();

        if (!file_exists($root)) {
            FileHelper::createDirectory($root, 0754);
        }

        $htmlRoot = '/' . $this->getFileDir();

        $currentPath = $this->getFileDir() . ($path ? '/' . $path : '');

        $uploadForm = new UploadForm();

        if ($uploadForm->load((array)$request->post())) {
            $uploadForm->files = UploadedFile::getInstances($uploadForm, 'files');
            if ($uploadForm->validate()) {
                foreach ($uploadForm->files as $file) {
                    $slug = Slugger::slug($file->baseName ?: '');
                    $extension = $file->extension ?: '';
                    $file->saveAs($currentPath . '/' . $slug . ($extension ? '.' . $extension : ''));
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

        return $this->render('index', [
            'htmlRoot' => $htmlRoot,
            'root' => $root,
            'path' => $path,
            'items' => $items,
            'directoryForm' => $directoryForm,
            'uploadForm' => $uploadForm,
        ]);
    }

    public function actionDelete(string $name, Request $request, File $fileHandler): ?Response
    {
        $name = FilenameEscaper::escape($name);
        $file = $fileHandler->set($this->getFileDir() . '/' . $name, true);

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
        $form = new RenameForm();
        $form->name = $name;

        if ($form->load((array)$request->post()) && $form->validate()) {
            $path = FilenameEscaper::escape($path);
            $name = FilenameEscaper::escape($name);

            $file = $fileHandler->set($this->getFileDir() . '/' . $path . '/' . $name, true);

            $to = FilenameEscaper::escape($form->name);

            if (!$file->rename($this->getFileDir() . '/' . $path . '/' . $to)) {
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
