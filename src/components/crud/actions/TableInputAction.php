<?php

namespace app\components\crud\actions;

use CActiveRecord;

class TableInputAction extends CrudAction
{
    public $success = 'Изменения сохранены';
    public $addSuccess = 'Добавлено';
    public $error = 'Error';

    public $modelClass;
    public $formClass;
    public $order = 'title ASC';
    public $view = 'index';

    public function run()
    {
        // Grid
        $items = CActiveRecord::model($this->modelClass)->findAll([
            'order' => $this->order,
        ]);

        $formName = (new \ReflectionClass($this->formClass))->getShortName();

        if (isset($_POST[$formName])) {
            $valid = true;

            foreach ($items as $item) {
                if (isset($_POST[$formName][$item->getPrimaryKey()])) {
                    $item->attributes = $_POST[$formName][$item->getPrimaryKey()];
                }
                $valid = $item->validate() && $valid;
            }

            if ($valid) {
                foreach ($items as $item) {
                    if (isset($_POST[$formName][$item->getPrimaryKey()])) {
                        $item->attributes = $_POST[$formName][$item->getPrimaryKey()];
                        $item->save();
                    }
                }

                $this->success($this->success);

                $items = CActiveRecord::model($this->modelClass)->findAll([
                    'order' => $this->order ?: 'title ASC',
                ]);
            }
        }

        // Add new
        $form = new $this->formClass;

        if (isset($_POST[$formName])) {
            $form->attributes = $_POST[$formName];

            if ($form->validate()) {
                $model = $this->createModel();
                $model->attributes = $_POST[$formName];

                if ($model->save()) {
                    $this->success($this->addSuccess);
                    $this->controller->refresh();
                }
            }
        }

        $this->controller->render($this->view, ['itemForm' => $form, 'items' => $items]);
    }
}
