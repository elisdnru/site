<?php

namespace app\modules\file\controllers\admin;

use app\components\FilenameEscaper;
use app\components\Slugger;
use app\extensions\file\File;
use app\modules\file\forms\RenameForm;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use app\components\AdminController;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\User as WebUser;

class FileController extends AdminController
{
    private const UPLOAD_COUNT = 7;
    private const UPLOAD_PATH = 'upload/media';

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

    public function actionIndex(Request $request, File $fileHandler, string $path = ''): Response|string
    {
        $root = Yii::getAlias('@webroot') . '/' . $this->getFileDir();
        $htmlRoot = '/' . $this->getFileDir();

        $currentPath = $this->getFileDir() . ($path ? '/' . $path : '');

        if (!file_exists($this->getFileDir() . '/' . $path)) {
            $fileHandler->createDir(0754, $this->getFileDir() . '/' . $path);
        }

        if (!empty($_FILES)) {
            for ($i = 1; $i <= self::UPLOAD_COUNT; $i++) {
                $index = 'file_' . $i;
                if (isset($_FILES[$index])) {
                    $this->uploadFile($index, $currentPath, $fileHandler);
                }
            }
            return $this->refresh();
        }

        if ($folderName = (string)$request->getBodyParam('folderName')) {
            if (preg_match('|^[\\w-]+$|i', $folderName, $t)) {
                $fileHandler->createDir(0754, $this->getFileDir() . '/' . ($path ? $path . '/' : '') . $folderName);
            }
        }

        $dir = $fileHandler->set($root . '/' . $path);

        $items = array_map(
            fn (string $path): File => $fileHandler->set($path),
            (array)$dir->getContents()
        );

        return $this->render('index', [
            'htmlRoot' => $htmlRoot,
            'root' => $root,
            'path' => $path,
            'items' => $items,
            'uploadCount' => self::UPLOAD_COUNT,
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

    private function uploadFile(string $field, string $currentPath, File $fileHandler): bool
    {
        $success = false;

        $uploaded = $fileHandler->set($field, true);

        $slug = Slugger::slug($uploaded->getFilename() ?: '');
        $extension = $uploaded->getExtension() ?: '';

        $file = $currentPath . '/' . $slug . '.' . $extension;

        if (!$uploaded->move($file)) {
            $success = true;
        }

        return $success;
    }

    private function getFileDir(): string
    {
        $user = $this->loadUser();

        if ($user->role !== Access::ROLE_ADMIN) {
            return self::UPLOAD_PATH . '/users/' . $user->username;
        }

        return self::UPLOAD_PATH;
    }

    private function loadUser(): User
    {
        return User::findOne($this->user->id) ?: throw new ForbiddenHttpException();
    }
}
