<?php

namespace app\widgets\grid;

use CButtonColumn;

class ButtonColumn extends CButtonColumn
{
    public function init(): void
    {
        if ($this->updateButtonImageUrl === null) {
            $this->updateButtonImageUrl = '/images/admin/edit.png';
        }
        if ($this->deleteButtonImageUrl === null) {
            $this->deleteButtonImageUrl = '/images/admin/del.png';
        }
        if ($this->viewButtonImageUrl === null) {
            $this->viewButtonImageUrl = '/images/admin/view.png';
        }

        parent::init();
    }
}
