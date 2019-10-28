<?php

namespace app\modules\file\controllers\admin;

use app\modules\user\models\Access;
use app\modules\user\models\User;
use CHttpException;
use app\components\AdminController;
use app\components\helpers\FileHelper;
use app\components\helpers\TextHelper;
use Yii;
use yii\helpers\Url;

class FileController extends AdminController
{
    const THUMB_IMAGE_WIDTH = 84;
    const FILES_UPLOAD_COUNT = 7;

    protected $uploadRootPath = 'upload/media';

    public function filters(): array
    {
        return array_merge(parent::filters(), [
            'PostOnly + delete, rename, process',
        ]);
    }

    public function actionIndex($path = ''): string
    {
        $root = Yii::getPathOfAlias('webroot') . '/' . $this->getFileDir();
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
            $this->refresh();
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

    public function actionDelete($name): void
    {
        $name = FileHelper::escape($name);
        $file = Yii::$app->file->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new CHttpException(404, 'Файл не найден');
        }

        if (!$file->delete()) {
            throw new CHttpException(400, 'Ошибка удаления');
        }

        $this->redirectOrAjax();
    }

    public function actionRename($path): void
    {
        $name = FileHelper::escape(Yii::$app->request->post('name'));
        $to = FileHelper::escape(Yii::$app->request->post('to'));

        if (!$name || !$to) {
            throw new CHttpException(400, 'Некорректный запрос');
        }

        $name = ($path ? $path . '/' : '') . $name;

        $file = Yii::$app->file->set($this->getFileDir() . '/' . $name, true);

        if (!$file) {
            throw new CHttpException(404, 'Файл не найден');
        }

        if (!$file->rename($to)) {
            throw new CHttpException(400, 'Ошибка переименования');
        }

        $this->redirectOrAjax(Url::to(['index', 'path' => $path]));
    }

    protected function uploadPostFile($field, $curpath): bool
    {
        $success = false;

        $uploaded = Yii::$app->file->set($field, true);

        if ($uploaded) {
            if ($uploaded->getBasename() === '.htaccess') {
                return 'Отказано в доступе к загрузке файла .htaccess';
            }

            $file = $curpath . '/' . TextHelper::strToChpu($uploaded->getFilename()) . '.' . $uploaded->getExtension();

            if (!$uploaded->Move($file)) {
                $success = true;
            }

            if ($success && in_array($uploaded->getExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $orig = Yii::$app->image->load($file);

                if ($orig && $orig->getWidth() > self::THUMB_IMAGE_WIDTH) {
                    $orig->thumb(self::THUMB_IMAGE_WIDTH, false)->save($curpath . '/' . TextHelper::strToChpu($uploaded->getFilename()) . '_prev.' . $uploaded->getExtension());
                }
            }
        }

        return $success;
    }

    public function actionProcess($path): void
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
                                    Yii::app()->user->setFlash('success', 'Удалено');
                                }
                            }
                            break;
                    }
                }
            }
        }

        $this->redirectOrAjax(Url::to(['index', 'path' => $path]));
    }

    protected function getFileDir(): string
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
        return User::findOne(Yii::app()->user->id);
    }
}
