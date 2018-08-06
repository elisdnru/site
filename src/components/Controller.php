<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $menu = [];
    public $breadcrumbs = [];

    protected function beforeAction($action)
    {
        DTimer::log('system');
        return parent::beforeAction($action);
    }

    public function render($view, $data = null, $return = false)
    {
        DTimer::log('action');
        if ($this->beforeRender($view)) {
            DTimer::log('beforeRender');

            $output = $this->renderPartial($view, $data, true);
            DTimer::log('render');

            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false) {
                $output = $this->renderFile($layoutFile, ['content' => $output], true);
                DTimer::log('renderLayout');
            }

            $this->afterRender($view, $output);
            DTimer::log('afterRender');

            $output = $this->processOutput($output);
            DTimer::log('processOutput');

            if ($return) {
                return $output;
            } else {
                echo $output;
                //if (YII_DEBUG) DTimer::show();
            }
        }
    }
}
