<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class DIndexAction extends DCrudAction
{
    /**
     * @var string view file for rendering
     */
    public $view = 'index';
    /**
     * @var string view for rendering for Ajax request
     */
    public $ajaxView = '';
    /**
     * @var string class of data provider
     */
    public $providerClass = 'CActiveDataProvider';

    public function run()
    {
        $model = $this->getIndexProviderModel();

        $provider = $this->providerClass;

        $dataProvider = new $provider($model);

        if ($this->ajaxView && Yii::app()->request->isAjaxRequest)
        {
            $this->controller->renderPartial($this->ajaxView, array(
                'dataProvider'=>$dataProvider,
            ));
        }
        else
        {
            $this->controller->render($this->view, array(
                'dataProvider'=>$dataProvider,
            ));
        }
    }
}
