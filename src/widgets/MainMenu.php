<?php

declare(strict_types=1);

namespace app\widgets;

use Yii;
use yii\widgets\Menu;

class MainMenu extends Menu
{
    public function init(): void
    {
        parent::init();

        $isActive = static function (string $base): callable {
            return static function () use ($base): bool {
                $path = Yii::$app->request->pathInfo;
                return mb_strpos($path . '/', $base . '/', 0, 'UTF-8') === 0;
            };
        };

        $this->items = [
            ['label' => 'ElisDN', 'url' => ['/home/default/index']],
            ['label' => 'Блог', 'url' => ['/blog/default/index'], 'active' => $isActive('blog')],
            ['label' => 'Скринкасты', 'url' => ['/edu/default/index']],
            ['label' => 'Продукты', 'url' => ['/products/default/index'], 'options' => ['class' => 'important']],
            ['label' => 'Портфолио', 'url' => ['/portfolio/default/index'], 'active' => $isActive('portfolio')],
            ['label' => 'Контакты', 'url' => ['/contacts/default/index']],
        ];
    }
}
