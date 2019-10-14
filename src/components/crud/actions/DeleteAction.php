<?php

namespace app\components\crud\actions;

class DeleteAction extends CrudAction
{
    /**
     * @var string success message
     */
    public $success = 'Deleted successfully';
    /**
     * @var string error message
     */
    public $error = 'Error';

    public function run(): void
    {
        $this->checkIsPostRequest();

        $model = $this->loadModel();

        $this->clientCallback('beforeDelete', $model);

        if ($model->delete()) {
            $this->success($this->success);
        } else {
            $this->error($this->error);
        }

        $this->redirectToReferrer();
    }
}
