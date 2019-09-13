<?php

namespace app\modules\comment\controllers;

use CommentAdminControllerBase;

class CommentAdminController extends CommentAdminControllerBase
{
    protected function getModelName()
    {
        return 'Comment';
    }
}
