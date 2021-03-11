<?php

declare(strict_types=1);

namespace app\modules\search\models;

interface Material
{
    public function getSearchTitle(): string;
    public function getSearchUrl(): string;
    public function getSearchImage(): ?Image;
}
