<?php

namespace app\modules\comment\controllers;

use CommentAdminControllerBase;
use Yii;

Yii::import('application.modules.comment.components.CommentAdminControllerBase');

class CommentAdminController extends CommentAdminControllerBase
{
    protected function getModelName()
    {
        return 'Comment';
    }
}
