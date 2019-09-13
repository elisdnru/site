<?php

namespace app\modules\comment\controllers;

use app\modules\comment\components\CommentAdminControllerBase;

class CommentAdminController extends CommentAdminControllerBase
{
    protected function getModelName()
    {
        return 'Comment';
    }
}
