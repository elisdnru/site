<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class DDeleteAction extends DCrudAction
{
    /**
     * @var string success message
     */
    public $success = 'Deleted successfully';
    /**
     * @var string error message
     */
    public $error = 'Error';

    public function run()
    {
        $this->checkIsPostRequest();

        $model = $this->loadModel();

        $this->clientCallback('beforeDelete', $model);

        if ($model->delete())
            $this->success($this->success);
        else
            $this->error($this->error);

        $this->redirectToReferrer();
    }
}
