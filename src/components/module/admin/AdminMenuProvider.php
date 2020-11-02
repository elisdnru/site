<?php

namespace app\components\module\admin;

interface AdminMenuProvider
{
    public static function adminMenu(): array;
}
