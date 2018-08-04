<?php

class ConfigAdminController extends DAdminController
{
    public function actionIndex()
    {
        $items = Config::model()->findAll(array('order'=>'param ASC'));

        if(isset($_POST['Config']))
        {
            $valid=true;

            foreach($items as $item)
            {
                if(isset($_POST['Config'][$item->id])) {
                    $item->attributes = $_POST['Config'][$item->id];
                    $valid = $item->validate() && $valid;
                }
            }

            if($valid)
            {
                foreach($items as $item)
                {
                    if(isset($_POST['Config'][$item->id])){
                        $item->attributes=$_POST['Config'][$item->id];
                        $item->save();
                    }
                }

                Yii::app()->user->setFlash('success','Изменения сохранены');

                $items=Config::model()->findAll(array('order'=>'param ASC'));
            }
            else
                Yii::app()->user->setFlash('error','Ошибка');
        }

        $this->render('index',array('items'=>$items));
    }
}