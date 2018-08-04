<?php

Yii::import('application.modules.crud.components.*');

class GalleryAdminController extends DAdminController
{
    const FILES_UPLOAD_COUNT = 7;

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + delete, renamefile, upload, process',
        ));
    }

    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'DAdminAction',
                'view'=>'index',
                'ajaxView'=>'_grid'
            ),
            'create'=>'DCreateAction',
            'update'=>'DUpdateAction',
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function actionFiles($id)
    {
        $gallery = $this->loadModel($id);

        $path = $gallery->alias;

        $root = Yii::getPathOfAlias('webroot').'/'.NewsGallery::GALLERY_PATH;
        $htmlroot = Yii::app()->request->baseUrl.'/'.NewsGallery::GALLERY_PATH;

        if (!empty($_FILES))
        {
            for ($i = 1; $i <= self::FILES_UPLOAD_COUNT; $i++)
            {
                if (isset($_FILES['file_'.$i]))
                    $gallery->uploadPostFile('file_'.$i);
            }
            $this->refresh();
        }

        $this->render('files', array(
            'model'=>$gallery,
            'htmlroot'=>$htmlroot,
            'root'=>$root,
            'path'=>$path,
            'upload_count'=>self::FILES_UPLOAD_COUNT,
        ));
    }

    public function actionDelfile($id, $name)
    {
        $gallery = $this->loadModel($id);

        if (!$gallery->deleteFile($name))
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }

    public function actionRenamefile($id)
    {
        $name = Yii::app()->request->getParam('name');
        $to = Yii::app()->request->getParam('to');

        if (!$name || !$to)
            throw new CHttpException(400, 'Некорректный запрос');

        $gallery = $this->loadModel($id);

        if (!$gallery->renameFile($name, $to))
            throw new CHttpException(400, 'Ошибка переименования');

        $this->redirectOrAjax($this->createUrl('files', array('id'=>$id)));
    }

    public function actionUpload($id)
    {
        $gallery = $this->loadModel($id);

        if (!empty($_FILES))
        {
            $up = $gallery->uploadPostFile('Filedata');
            echo $up == 1 ? 1 : $up;
        }

        Yii::app()->end();
    }

    public function actionCheckexists($id)
    {
        if (isset($_POST['filename']))
        {
            $gallery = $this->loadModel($id);
            echo $gallery->isFileExists($_POST['filename']) ? 1 : 0;
        }
        else
            echo 0;

        Yii::app()->end();
    }

    public function actionProcess($id)
    {
        $action = Yii::app()->request->getPost('action');

        if ($action)
        {
            $gallery = $this->loadModel($id);

            $files = $gallery->getFileNameList();

            foreach ($files as $filename)
            {
                switch($action)
                {
                    case 'del':
                        if (Yii::app()->request->getPost('del_'.md5($filename)))
                            $gallery->deleteFile($filename);
                        break;
                }
            }
        }

        $this->redirectOrAjax($this->createUrl('files', array('id'=>$id)));
    }

    public function actionRegenerate($id)
    {
        $gallery = $this->loadModel($id);
        $gallery->createThumbs();

        if (!Yii::app()->request->isAjaxRequest)
        {
            Yii::app()->user->setFlash('success','Превью перегенерированы');
            $this->redirect($this->createUrl('files', array('id'=>$id)));
        }
    }

    public function actionClearthumbs($id)
    {
        $gallery = $this->loadModel($id);
        $gallery->clearThumbs();

        if (!Yii::app()->request->isAjaxRequest)
        {
            Yii::app()->user->setFlash('success','Превью удалены');
            $this->redirect($this->createUrl('files', array('id'=>$id)));
        }
    }

    /**
     * @return NewsGallery
     */
    public function createModel()
    {
        $model = new NewsGallery();
        return $model;
    }

    /**
     * @param $id
     * @return NewsGallery
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = NewsGallery::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }

}
