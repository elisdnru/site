<?php

Yii::import('application.modules.page.models.*');

class DefaultController extends GraduateBaseController
{
	public function actionIndex()
	{
        $grades = GraduateGrade::model()->cache(0, new Tags('graduate'))->findAll(array(
            'order'=>'t.year ASC, t.number ASC, t.letter ASC',
        ));

        $this->render('index',array(
            'grades'=>$grades,
            'page'=>$this->loadGraduatePage(),
        ));
	}

	public function actionYear($year)
	{
		$grades = GraduateGrade::model()->cache(0, new Tags('graduate'))->findAll(array(
			'condition'=>'t.year = :year',
			'params'=>array(':year'=>$year),
			'order'=>'t.number ASC, t.letter ASC',
		));

        $this->render('year', array(
            'grades'=>$grades,
            'year'=>$year,
            'page'=>$this->loadGraduatePage(),
        ));
	}

	public function actionRewards()
	{
		$graduates = GraduateGraduate::model()->cache(0, new Tags('graduate'))->findAll(array(
			'condition'=>'t.reward <> 0',
			'with'=>array('grade'),
			'order'=>'grade.year ASC, t.reward DESC, t.lastname ASC',
		));

        $this->render('rewards', array(
            'graduates'=>$graduates,
            'page'=>$this->loadGraduatePage(),
        ));
	}

    protected function loadGraduatePage()
    {
        if (!$page = Page::model()->cache(0, new Tags('page'))->findByAlias('graduate'))
        {
            $page = new Page();
            $page->title = 'Выпускники';
            $page->pagetitle = $page->title;
        }
        return $page;
    }
}