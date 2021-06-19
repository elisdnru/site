<?php

declare(strict_types=1);

namespace app\components\module\admin;

interface AdminDashboardItem
{
    public function adminGroup(): string;

    public function adminName(): string;
}
