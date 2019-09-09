<?php

class DownloadController extends DController
{
    public function actionThumb()
    {
        $file = trim(Yii::app()->request->requestUri, '/');

        if (!$thumb = Yii::app()->uploader->checkThumbExists($file)) {
            throw new CHttpException(404, 'Not found');
        }

        $this->redirect('/' . $file);
    }
}
