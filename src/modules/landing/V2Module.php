<?php

namespace app\modules\landing;

use app\components\module\Module as Base;
use app\components\module\routes\UrlProvider;

class V2Module extends Base implements UrlProvider
{
    public $controllerNamespace = __NAMESPACE__ . '\controllers';

    public function getGroup(): string
    {
        return 'Контент';
    }

    public function getName(): string
    {
        return 'Лендинги';
    }

    public static function adminMenu(): array
    {
        return [
            ['label' => 'Лендинги', 'url' => ['/landing/admin/landing/index'], 'icon' => 'fileicon.jpg'],
            ['label' => 'Добавить лендинг', 'url' => ['/landing/admin/landing/create'], 'icon' => 'add.png'],
        ];
    }

    public static function notifications(): array
    {
        return [];
    }

    public static function rules(): array
    {
        return [
            ['class' => components\v2\LandingUrlRule::class, 'cache' => 3600 * 24],
        ];
    }

    public static function rulesPriority(): int
    {
        return -1;
    }
}
