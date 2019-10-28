<?php

namespace app\components\crud\actions;

use CActiveRecord;
use CForm;
use ReflectionClass;
use Yii;

class TableInputAction extends CrudAction
{
    public $success = 'Изменения сохранены';
    public $addSuccess = 'Добавлено';
    public $error = 'Error';

    public $modelClass;
    public $formClass;
    public $order = 'title ASC';
    public $view = 'index';

    public function run(): void
    {
        // Grid
        $items = CActiveRecord::model($this->modelClass)->findAll([
            'order' => $this->order,
        ]);

        $formName = (new ReflectionClass($this->formClass))->getShortName();

        if ($post = Yii::$app->request->post($formName)) {
            $valid = true;

            foreach ($items as $item) {
                if (isset($post[$item->getPrimaryKey()])) {
                    $item->attributes = $post[$item->getPrimaryKey()];
                }
                $valid = $item->validate() && $valid;
            }

            if ($valid) {
                foreach ($items as $item) {
                    if (isset($post[$item->getPrimaryKey()])) {
                        $item->attributes = $post[$item->getPrimaryKey()];
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
        /** @var CForm $form */
        $form = new $this->formClass;

        if (isset($post)) {
            $form->attributes = $post;

            if ($form->validate()) {
                $model = $this->createModel();
                $model->attributes = $post;

                if ($model->save()) {
                    $this->success($this->addSuccess);
                    $this->controller->refresh();
                }
            }
        }

        $this->controller->render($this->view, ['itemForm' => $form, 'items' => $items]);
    }
}
