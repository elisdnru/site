<?php

class PhotoController extends GalleryBaseController
{
	public function actionShow($id)
	{
        $model = $this->loadModel($id);
        $this->checkUrl($model->url);

		$next = GalleryPhoto::model()->find(array(
			'condition'=>'t.id > :id AND public = 1',
			'order'=>'t.id ASC',
			'params'=>array(
				'id'=>$model->id,
			),
		));

		$prev = GalleryPhoto::model()->find(array(
			'condition'=>'t.id < :id AND public = 1',
			'order'=>'t.id DESC',
			'params'=>array(
				'id'=>$model->id,
			),
		));

		$this->render('show', array(
            'model'=>$model,
            'prev'=>$prev,
            'next'=>$next,
        ));
	}

	/**
	 * @param $id
	 * @return GalleryPhoto
	 * @throws CHttpException
	 */
	protected function loadModel($id)
    {
        if ($this->moduleAllowed('gallery')) {
            $condition = '';
        } else {
            $condition = 'public = 1';
        }

        $model = GalleryPhoto::model()->findByPk($id, $condition);
        if($model===null)
            throw new CHttpException(404, 'Страница не найдена');

        return $model;
    }
}