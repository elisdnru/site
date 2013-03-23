<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class DAdminAction extends DCrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'admin';
    /**
     * @var string view for rendering for Ajax request
     */
    public $ajaxView = '';
    /**
     * @var string search scenarion name
     */
    public $scenario = 'search';

    public function run()
    {
        $modelName = get_class($this->createModel());

        $model = new $modelName($this->scenario);

        $model->unsetAttributes();
        if(isset($_GET[$modelName]))
            $model->attributes=$_GET[$modelName];

        if ($this->ajaxView && Yii::app()->request->isAjaxRequest)
        {
            $this->controller->renderPartial($this->ajaxView,array(
                'model'=>$model,
            ));
        }
        else
        {
            $this->controller->render($this->view ,array(
                'model'=>$model,
            ));
        }
    }
}
