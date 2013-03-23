<?php

Yii::import('comment.components.CommentAdminControllerBase');

class CommentAdminController extends CommentAdminControllerBase
{
    protected function getModelName()
    {
        return 'Comment';
    }
}