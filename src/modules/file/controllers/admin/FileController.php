<?php

namespace app\modules\file\controllers\admin;

use app\components\FileNameFilter;
use app\extensions\file\File;
use app\extensions\image\ImageHandler;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use app\components\AdminController;
use app\components\Transliterator;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;
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
                    'rename' => ['post'],
                    'process' => ['post'],
                ],
            ]
        ]);
    }

    public function actionIndex(File $fileHandler, ImageHandler $imageHandler, string $path = '')
    {
        $root = Yii::getAlias('@webroot') . '/' . $this->getFileDir();
        $htmlroot = '/' . $this->getFileDir();

        $curpath = $this->getFileDir() . ($path ? '/' . $path : '');

        if (!file_exists($this->getFileDir() . '/' . $path)) {
            $fileHandler->createDir(0754, $this->getFileDir() . '/' . $path);
        }

        if (!empty($_FILES)) {
            for ($i = 1; $i <= self::FILES_UPLOAD_COUNT; $i++) {
                if (isset($_FILES['file_' . $i])) {
                    $this->uploadPostFile('file_' . $i, $curpath, $fileHandler, $imageHandler);
                }
            }
            return $this->refresh();
        }

        if (!empty($_POST['foldername'])) {
            $foldername = $_POST['foldername'];

            if (preg_match('|^[\\w\\d_-]+$|i', $foldername, $t)) {
                $fileHandler->CreateDir(0754, $this->getFileDir() . '/' . ($path ? $path . '/' : '') . $foldername);
            }
        }

        return $this->render('index', [
            'htmlroot' => $htmlroot,
            'root' => $root,
            'path' => $path,
            'upload_count' => self::FILES_UPLOAD_COUNT,
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

    public function actionRename(string $path, Request $request, File $fileHandler): ?Response
    {
        $name = FileNameFilter::escape($request->post('name'));
        $to = FileNameFilter::escape($request->post('to'));

        if (!$name || !$to) {
            throw new BadRequestHttpException('Некорректный запрос');
        }

        $name = ($path ? $path . '/' : '') . $name;

        $file = $fileHandler->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new NotFoundHttpException();
        }

        if (!$file->rename($to)) {
            throw new BadRequestHttpException('Ошибка переименования');
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index', 'path' => $path]);
        }
        return null;
    }

    private function uploadPostFile($field, $curpath, File $fileHandler, ImageHandler $imageHandler): bool
    {
        $success = false;

        $uploaded = $fileHandler->set($field, true);

        if ($uploaded) {
            if ($uploaded->getBasename() === '.htaccess') {
                throw new BadRequestHttpException('Отказано в доступе к загрузке файла .htaccess');
            }

            $file = $curpath . '/' . Transliterator::slug($uploaded->getFilename()) . '.' . $uploaded->getExtension();

            if (!$uploaded->Move($file)) {
                $success = true;
            }

            if ($success && in_array($uploaded->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $orig = $imageHandler->load($file);

                if ($orig && $orig->getWidth() > self::THUMB_IMAGE_WIDTH) {
                    $orig->thumb(self::THUMB_IMAGE_WIDTH, false)->save($curpath . '/' . Transliterator::slug($uploaded->getFilename()) . '_prev.' . $uploaded->getExtension());
                }
            }
        }

        return $success;
    }

    public function actionProcess(string $path, Request $request, Session $session, File $fileHandler): ?Response
    {
        $action = $request->post('action');

        if ($action) {
            $curpath = $this->getFileDir() . ($path ? '/' . $path : '');
            $dir = $fileHandler->set($curpath);

            foreach ($dir->getContents() as $item) {
                $file = $fileHandler->set($item);

                if ($file->getBasename() !== '.htaccess') {
                    switch ($action) {
                        case 'del':
                            if ($request->post('del_' . md5($file->getBasename()))) {
                                if ($file->Delete()) {
                                    $session->setFlash('success', 'Удалено');
                                }
                            }
                            break;
                    }
                }
            }
        }

        if (!$request->getIsAjax()) {
            return $this->redirect(['index', 'path' => $path]);
        }
        return null;
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
