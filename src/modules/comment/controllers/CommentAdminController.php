<?php

namespace app\modules\comment\controllers;

use app\modules\comment\components\CommentAdminControllerBase;
use app\modules\comment\models\Comment;

class CommentAdminController extends CommentAdminControllerBase
{
    protected function getModelName()
    {
        return Comment::class;
    }
}
