<?php

namespace app\modules\file\controllers\admin;

use app\components\FileNameFilter;
use app\modules\user\models\Access;
use app\modules\user\models\User;
use app\components\AdminController;
use app\components\Transliterator;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FileController extends AdminController
{
    public const THUMB_IMAGE_WIDTH = 84;
    public const FILES_UPLOAD_COUNT = 7;

    protected $uploadRootPath = 'upload/media';

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

    public function actionIndex(string $path = '')
    {
        $root = Yii::getAlias('@webroot') . '/' . $this->getFileDir();
        $htmlroot = '/' . $this->getFileDir();

        $curpath = $this->getFileDir() . ($path ? '/' . $path : '');

        if (!file_exists($this->getFileDir() . '/' . $path)) {
            Yii::$app->file->createDir(0754, $this->getFileDir() . '/' . $path);
        }

        if (!empty($_FILES)) {
            for ($i = 1; $i <= self::FILES_UPLOAD_COUNT; $i++) {
                if (isset($_FILES['file_' . $i])) {
                    $this->uploadPostFile('file_' . $i, $curpath);
                }
            }
            return $this->refresh();
        }

        if (!empty($_POST['foldername'])) {
            $foldername = $_POST['foldername'];

            if (preg_match('|^[\\w\\d_-]+$|i', $foldername, $t)) {
                Yii::$app->file->CreateDir(0754, $this->getFileDir() . '/' . ($path ? $path . '/' : '') . $foldername);
            }
        }

        return $this->render('index', [
            'htmlroot' => $htmlroot,
            'root' => $root,
            'path' => $path,
            'upload_count' => self::FILES_UPLOAD_COUNT,
        ]);
    }

    public function actionDelete(string $name): ?Response
    {
        $name = FileNameFilter::escape($name);
        $file = Yii::$app->file->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new NotFoundHttpException();
        }

        if (!$file->delete()) {
            throw new BadRequestHttpException('Ошибка удаления');
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index']);
        }
        return null;
    }

    public function actionRename(string $path): ?Response
    {
        $name = FileNameFilter::escape(Yii::$app->request->post('name'));
        $to = FileNameFilter::escape(Yii::$app->request->post('to'));

        if (!$name || !$to) {
            throw new BadRequestHttpException('Некорректный запрос');
        }

        $name = ($path ? $path . '/' : '') . $name;

        $file = Yii::$app->file->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new NotFoundHttpException();
        }

        if (!$file->rename($to)) {
            throw new BadRequestHttpException('Ошибка переименования');
        }

        if (!Yii::$app->request->getIsAjax()) {
            return $this->redirect(['index', 'path' => $path]);
        }
        return null;
    }

    private function uploadPostFile($field, $curpath): bool
    {
        $success = false;

        $uploaded = Yii::$app->file->set($field, true);

        if ($uploaded) {
            if ($uploaded->getBasename() === '.htaccess') {
                return 'Отказано в доступе к загрузке файла .htaccess';
            }

            $file = $curpath . '/' . Transliterator::slug($uploaded->getFilename()) . '.' . $uploaded->getExtension();

            if (!$uploaded->Move($file)) {
                $success = true;
            }

            if ($success && in_array($uploaded->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $orig = Yii::$app->image->load($file);

                if ($orig && $orig->getWidth() > self::THUMB_IMAGE_WIDTH) {
                    $orig->thumb(self::THUMB_IMAGE_WIDTH, false)->save($curpath . '/' . Transliterator::slug($uploaded->getFilename()) . '_prev.' . $uploaded->getExtension());
                }
            }
        }

        return $success;
    }

    public function actionProcess(string $path): ?Response
    {
        $action = Yii::$app->request->post('action');

        if ($action) {
            $curpath = $this->getFileDir() . ($path ? '/' . $path : '');
            $dir = Yii::$app->file->set($curpath);

            foreach ($dir->getContents() as $item) {
                $file = Yii::$app->file->set($item);

                if ($file->getBasename() !== '.htaccess') {
                    switch ($action) {
                        case 'del':
                            if (Yii::$app->request->post('del_' . md5($file->getBasename()))) {
                                if ($file->Delete()) {
                                    Yii::$app->session->setFlash('success', 'Удалено');
                                }
                            }
                            break;
                    }
                }
            }
        }

        if (!Yii::$app->request->getIsAjax()) {
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
        return User::findOne(Yii::$app->user->id);
    }
}
