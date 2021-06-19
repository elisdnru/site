<?php

declare(strict_types=1);

namespace app\modules\comment\models;

interface Material
{
    public function getCommentTitle(): string;

    public function getCommentUrl(): string;
}
