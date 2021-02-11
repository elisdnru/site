<?php

namespace app\modules\file\controllers\admin;

use app\components\FileNameFilter;
use app\components\Slugger;
use app\extensions\file\File;
use app\extensions\image\Image;
use app\modules\file\forms\RenameForm;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use app\components\AdminController;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\User as WebUser;

class FileController extends AdminController
{
    public const THUMB_IMAGE_WIDTH = 84;
    public const FILES_UPLOAD_COUNT = 7;

    protected string $uploadRootPath = 'upload/media';

    private WebUser $user;

    public function __construct(string $id, Module $module, WebUser $user, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->user = $user;
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'process' => ['post'],
                ],
            ]
        ]);
    }

    public function actionIndex(File $fileHandler, Image $image, string $path = ''): Response|string
    {
        $root = Yii::getAlias('@webroot') . '/' . $this->getFileDir();
        $htmlRoot = '/' . $this->getFileDir();

        $currentPath = $this->getFileDir() . ($path ? '/' . $path : '');

        if (!file_exists($this->getFileDir() . '/' . $path)) {
            $fileHandler->createDir(0754, $this->getFileDir() . '/' . $path);
        }

        if (!empty($_FILES)) {
            for ($i = 1; $i <= self::FILES_UPLOAD_COUNT; $i++) {
                $index = 'file_' . $i;
                if (isset($_FILES[$index])) {
                    $this->uploadPostFile($index, $currentPath, $fileHandler, $image);
                }
            }
            return $this->refresh();
        }

        if (!empty($_POST['folderName'])) {
            $folderName = (string)$_POST['folderName'];

            if (preg_match('|^[\\w-]+$|i', $folderName, $t)) {
                $fileHandler->CreateDir(0754, $this->getFileDir() . '/' . ($path ? $path . '/' : '') . $folderName);
            }
        }

        return $this->render('index', [
            'htmlRoot' => $htmlRoot,
            'root' => $root,
            'path' => $path,
            'uploadCount' => self::FILES_UPLOAD_COUNT,
        ]);
    }

    public function actionDelete(string $name, Request $request, File $fileHandler): ?Response
    {
        $name = FileNameFilter::escape($name);
        $file = $fileHandler->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new NotFoundHttpException();
        }

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
            $path = FileNameFilter::escape($path);
            $name = FileNameFilter::escape($name);

            $file = $fileHandler->set($this->getFileDir() . '/' . $path . '/' . $name, true);

            if (!$file) {
                throw new NotFoundHttpException();
            }

            $to = FileNameFilter::escape($form->name);

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

    private function uploadPostFile(
        string $field,
        string $currentPath,
        File $fileHandler,
        Image $image
    ): bool {
        $success = false;

        $uploaded = $fileHandler->set($field, true);

        if ($uploaded->getBasename() === '.htaccess') {
            throw new BadRequestHttpException('Отказано в доступе к загрузке файла .htaccess');
        }

        $slug = Slugger::slug($uploaded->getFilename() ?: '');
        $extension = $uploaded->getExtension() ?: '';

        $file = $currentPath . '/' . $slug . '.' . $extension;

        if (!$uploaded->move($file)) {
            $success = true;
        }

        if ($success && in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $orig = $image->load($file);

            if ($orig && $orig->getWidth() > self::THUMB_IMAGE_WIDTH) {
                $orig
                    ->thumb(self::THUMB_IMAGE_WIDTH, false)
                    ->save($currentPath . '/' . $slug . '_prev.' . $extension);
            }
        }

        return $success;
    }

    private function getFileDir(): string
    {
        $user = $this->loadUser();

        if ($user && $user->role !== Access::ROLE_ADMIN) {
            $dir = $this->uploadRootPath . '/users/' . $user->username;
        } else {
            $dir = $this->uploadRootPath;
        }

        return $dir;
    }

    private function loadUser(): ?User
    {
        return User::findOne($this->user->id);
    }
}
