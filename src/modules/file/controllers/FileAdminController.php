<?php

Yii::import('application.modules.uploader.components.DFileHelper');

class FileAdminController extends DAdminController
{
    const THUMB_IMAGE_WIDTH = 84;
    const FILES_UPLOAD_COUNT = 7;

    protected $uploadRootPath = 'upload/media';

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + delete, rename, process',
        ));
    }

    public function actionIndex($path='')
    {
        $root = Yii::getPathOfAlias('webroot').'/'.$this->getFileDir();
        $htmlroot = Yii::app()->request->baseUrl.'/'.$this->getFileDir();

        $curpath = $this->getFileDir().($path ? '/'.$path : '');

        if (!file_exists($this->getFileDir().'/'.$path))
             Yii::app()->file->CreateDir(0754, $this->getFileDir().'/'.$path);

        if (!empty($_FILES))
        {
            for ($i = 1; $i <= self::FILES_UPLOAD_COUNT; $i++)
            {
                if (isset($_FILES['file_'.$i]))
                    $this->uploadPostFile('file_'.$i, $curpath);
            }
            $this->refresh();
        }

        if (!empty($_POST['foldername']))
        {
            $foldername = $_POST['foldername'];

            if (preg_match('|^[\\w\\d_-]+$|i', $foldername, $t))
                Yii::app()->file->CreateDir(0754, $this->getFileDir().'/'.($path ? $path.'/' : '').$foldername);
        }

        $this->render('index', array(
            'htmlroot'=>$htmlroot,
            'root'=>$root,
            'path'=>$path,
            'upload_count'=>self::FILES_UPLOAD_COUNT,
        ));
    }

    public function actionDelete($name)
    {
        $name = DFileHelper::escape($name);
        $file = Yii::app()->file->set($this->getFileDir().'/'.$name, true);

        if (!$file)
            throw new CHttpException(404, 'Файл не найден');

        if (!$file->delete())
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }

    public function actionRename($path)
    {
        $name = DFileHelper::escape(Yii::app()->request->getParam('name'));
        $to = DFileHelper::escape(Yii::app()->request->getParam('to'));

        if (!$name || !$to)
            throw new CHttpException(400, 'Некорректный запрос');

        $name = ($path ? $path . '/' : '') . $name;

        $file = Yii::app()->file->set($this->getFileDir() . '/' . $name, true);

        if (!$file)
            throw new CHttpException(404, 'Файл не найден');

        if (!$file->rename($to))
            throw new CHttpException(400, 'Ошибка переименования');

        $this->redirectOrAjax($this->createUrl('index', array('path'=>$path)));
    }

    public function actionUpload($path)
    {
        $curpath = $this->getFileDir() . ($path ? '/'.$path : '');

        if (!empty($_FILES))
        {
            $up = $this->uploadPostFile('Filedata', $curpath);
            echo $up === 1 ? 1 : $up;
        }

        Yii::app()->end();
    }

    public function actionCheckexists($path)
    {
        if (isset($_POST['filename']))
        {
            $file = $this->getFileDir().($path ? '/'.$path : '').'/'.$_POST['filename'];
            echo Yii::app()->file->set($file)->exists ? 1 : 0;
        } else
            echo 0;

        Yii::app()->end();
    }

    protected function uploadPostFile($field, $curpath)
    {
        $success = false;
        $uploaded = Yii::app()->file->set($field, true);

        if ($uploaded)
        {
            if ($uploaded->basename == '.htaccess') return 'Отказано в доступе к загрузке файла .htaccess';

            $file = $curpath . '/' . DTextHelper::strToChpu($uploaded->filename) . '.' . $uploaded->extension;

            if (!$uploaded->Move($file))
                $success = true;

            if ($success && in_array($uploaded->extension, array('jpg', 'jpeg', 'png', 'gif')))
            {
                $orig = Yii::app()->image->load($file);

                if ($orig->width > self::THUMB_IMAGE_WIDTH)
                {
                    $orig->thumb(self::THUMB_IMAGE_WIDTH, false)->save($curpath.'/'.DTextHelper::strToChpu($uploaded->filename).'_prev.'.$uploaded->extension);
                }
            }

        }

        return $success ? 1 : 0;
    }

    public function actionProcess($path)
    {
        $action = Yii::app()->request->getPost('action');

        if ($action){

            $curpath = $this->getFileDir().($path ? '/'.$path : '');
            $dir = Yii::app()->file->set($curpath);

            foreach ($dir->contents as $item)
            {
                $file = Yii::app()->file->set($item);

                if ($file->basename != '.htaccess')
                {
                    switch($action)
                    {
                        case 'del':
                            if (Yii::app()->request->getPost('del_'.md5($file->basename))){
                                if ($file->Delete())
                                    Yii::app()->user->setFlash('success','Удалено');
                            }
                            break;
                    }

                }
            }
        }

        $this->redirectOrAjax($this->createUrl('index', array('path'=>$path)));

    }

    protected function getFileDir()
    {
        $user = $this->getUser();

        if ($user && $user->role != Access::ROLE_ADMIN)
            $dir = $this->uploadRootPath . '/users/' . $user->username;
        else
            $dir = $this->uploadRootPath;

        return $dir;
    }

}
