<?php

namespace app\modules\crud\components;

use CActiveRecord;
use CBehavior;
use Yii;

class TableInputBehavior extends CBehavior
{
    public function renderTableForm($params)
    {
        $modelName = $params['class'] ?? '';
        $formName = $params['form'] ?? '';
        $formOrder = $params['order'] ?? '';
        $view = $params['view'] ?? 'index';

        // Grid
        $items = CActiveRecord::model($modelName)->findAll(
            [
                'order' => $formOrder ?: 'title ASC',
            ]
        );

        if (isset($_POST[$modelName])) {
            $valid = true;

            foreach ($items as $item) {
                if (isset($_POST[$modelName][$item->id])) {
                    $item->attributes = $_POST[$modelName][$item->id];
                }
                $valid = $item->validate() && $valid;
            }

            if ($valid) {
                foreach ($items as $item) {
                    if (isset($_POST[$modelName][$item->id])) {
                        $item->attributes = $_POST[$modelName][$item->id];
                        $item->save();
                    }
                }

                Yii::app()->user->setFlash('success', 'Изменения сохранены');

                $items = CActiveRecord::model($modelName)->findAll([
                    'order' => $formOrder ?: 'title ASC',
                ]);
            }
        }

        // Add new
        $form = new $formName;

        if (isset($_POST[$formName])) {
            $form->attributes = $_POST[$formName];

            if ($form->validate()) {
                $model = new $modelName;
                $model->attributes = $_POST[$formName];

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Добавлено');
                    $this->owner->refresh();
                }
            }
        }

        $this->owner->render($view, ['categoryForm' => $form, 'items' => $items]);
    }
}
