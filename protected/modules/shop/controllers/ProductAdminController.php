<?php

Yii::import('application.modules.crud.components.*');

class ProductAdminController extends DAdminController
{

    public function filters()
    {
        return array_merge(parent::filters(), array(
            'PostOnly + imagedel, imagemain',
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
            'toggle'=>array(
                'class'=>'DToggleAction',
                'attributes'=>array('public', 'popular', 'inhome', 'sale')
            ),
            'update'=>'DUpdateAction',
            'delete'=>'DDeleteAction',
            'view'=>'DViewAction',
        );
    }

    public function actionCreate()
    {
        $model = $this->createModel();

        $attributes = ShopProductAttribute::model()->findAll(array(
            'order'=>'sort ASC',
        ));

        if(isset($_POST['ShopProduct']))
        {
            $model->attributes = $_POST['ShopProduct'];

            if($model->save()){

                if (isset($_POST['ShopProductAttribute']))
                {
                    foreach ($_POST['ShopProductAttribute'] as $attrid=>$attribute)
                    {
                        $attr = new ShopProductAttributeValue;
                        $attr->product_id = $model->id;
                        $attr->attribute_id = $attrid;
                        $attr->value = $attribute['value'];
                        $attr->save();
                    }
                }

                Yii::app()->user->setFlash('success','Товар добавлен');

                $model = $this->createModel();
                $model->type_id = $_POST['ShopProduct']['type_id'];
                $model->category_id = $_POST['ShopProduct']['category_id'];
            }
        }
        $this->render('create',array(
            'model'=>$model,
            'attributes'=>$attributes,
        ));
    }

    public function actionImagedel($id)
    {
        if (!$model = ShopImage::model()->findByPk($id))
            throw new CHttpException(404, 'Не найдено');

        if (!$model->delete())
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }

    public function actionImagemain($id)
    {
        if (!$model = ShopImage::model()->findByPk($id))
            throw new CHttpException(404, 'Не найдено');

        if ($model->product)
        {
            foreach ($model->product->images as $image)
            {
                $image->main = 0;
                $image->save();
            }
        }

        $model->main = 1;

        if (!$model->save())
            throw new CHttpException(400, 'Ошибка удаления');

        $this->redirectOrAjax();
    }

    public function actionGetCategories($id=0)
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, 'Некорректный запрос');

        $model = $this->loadOrCreateModel($id);

        $html = '';
        if (isset($_POST['type']) && (int)$_POST['type'])
        {
            $list = CHtml::dropDownList('category', $model->category_id, array(''=>'') + ShopCategory::model()->type($_POST['type'])->getTabList());
            $html = strip_tags($list, '<option>');
        }
        echo $html;

        Yii::app()->end();
    }

    public function actionGetAttributes($id=0)
    {
        if (!Yii::app()->request->isAjaxRequest)
            throw new CHttpException(400, 'Некорректный запрос');

        $model = $this->loadOrCreateModel($id);
        $attributes = $model->getOtherAttributes(Yii::app()->request->getPost('type'));

        $html = '';

        foreach($attributes as $attribute){
            $label = CHtml::tag('label', array(), $attribute->title);
            $input = CHtml::activeTextField($attribute, "[$attribute->id]value", array('maxlength'=>255));
            $html .= CHtml::tag('div', array('class'=>'row'), $label . $input);
        }

        echo $html;

        Yii::app()->end();
    }

    public function createModel()
    {
        $model = new ShopProduct;
        $model->count = 1000;
        $model->priority = 200;
        $model->public = 1;
        return $model;
    }

    protected function loadOrCreateModel($id)
    {
        if ((int)$id)
            $model = $this->loadModel($id);
        else
            $model = $this->createModel();

        return $model;
    }

    public function loadModel($id)
    {
        $model = ShopProduct::model()->findByPk((int)$id);
        if($model === null)
            throw new CHttpException(404, 'Не найдено');
        return $model;
    }


}