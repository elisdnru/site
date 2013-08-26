<?php

Yii::import('application.modules.crud.components.*');

class GraduateAdminController extends DAdminController
{
	public function filters()
	{
		return array_merge(parent::filters(), array(
			'postOnly + import',
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
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('public')
            ),
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

	public function actionImportList()
	{
		$model = new GraduateImportForm();

		if (isset($_POST['GraduateImportForm']))
		{
			$model->attributes = $_POST['GraduateImportForm'];
			if ($model->validate())
			{
				$transaction = Yii::app()->db->beginTransaction();

				$count_imported = 0;
				$count_total = 0;
				foreach ($model->getListLines() as $line)
				{
					@list($lastname, $firstname, $middlename) = preg_split('/[\s\.]+/', $line);
					$graduate = new GraduateGraduate();
					$graduate->lastname = trim($lastname, ' .');
					$graduate->firstname = trim($firstname, ' .');
					$graduate->middlename = trim($middlename, ' .');
					$graduate->grade_id = $model->grade_id;
					$graduate->public = 1;
					if ($graduate->save())
						$count_imported++;
					$count_total++;
				}

				if ($count_imported == $count_total)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Импорт произведён');

					$this->redirect($this->createUrl('index', array(
						'GraduateGraduate[year]' => $graduate->grade ? $graduate->grade->year : '',
						'GraduateGraduate[number]' => $graduate->grade ? $graduate->grade->number : '',
						'GraduateGraduate[letter]' => $graduate->grade ? $graduate->grade->letter : '',
					)));
				}
				else
				{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', 'Ошибка импорта. Проверьте правильность списка');
				}
			}
		}

		$this->render('import', array('model'=>$model));
	}

    public function createModel()
    {
        $model = new GraduateGraduate();
        $model->public = 1;
        $model->grade_id = Yii::app()->request->getQuery('grade');
        return $model;
    }

    public function loadModel($id)
    {
        $model = GraduateGraduate::model()->findByPk($id);

        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }
}