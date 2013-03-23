<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */
class DTableInputBehavior extends CBehavior
{
    public function renderTableForm($params)
    {
        $modelName = isset($params['class']) ? $params['class'] : '';
        $formName = isset($params['form']) ? $params['form'] : '';
        $formOrder = isset($params['order']) ? $params['order'] : '';
        $view = isset($params['view']) ? $params['view'] : 'index';

        // Grid
        $items = CActiveRecord::model($modelName)->findAll(
            array(
                'order' => $formOrder ? $formOrder : 'title ASC',
            )
        );

        if (isset($_POST[$modelName]))
        {
            $valid = true;

            foreach ($items as $item)
            {
                if (isset($_POST[$modelName][$item->id]))
                    $item->attributes = $_POST[$modelName][$item->id];
                $valid = $item->validate() && $valid;
            }

            if ($valid)
            {
                foreach ($items as $item)
                {
                    if (isset($_POST[$modelName][$item->id]))
                    {
                        $item->attributes = $_POST[$modelName][$item->id];
                        $item->save();
                    }
                }

                Yii::app()->user->setFlash('success', 'Изменения сохранены');

                $items = CActiveRecord::model($modelName)->findAll(array(
                    'order' => $formOrder ? $formOrder : 'title ASC',
                ));
            }
        }

        // Add new
        $form = new $formName;

        if (isset($_POST[$formName]))
        {
            $form->attributes = $_POST[$formName];

            if ($form->validate())
            {
                $model = new $modelName;
                $model->attributes = $_POST[$formName];

                if ($model->save())
                {
                    Yii::app()->user->setFlash('success', 'Добавлено');
                    $this->owner->refresh();
                }
            }
        }

        $this->owner->render($view, array('categoryForm' => $form, 'items' => $items));
    }
}
