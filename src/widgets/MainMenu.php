<?php

declare(strict_types=1);

namespace app\widgets;

use BadMethodCallException;
use Yii;
use yii\web\Request;
use yii\widgets\Menu;

final class MainMenu extends Menu
{
    public function init(): void
    {
        parent::init();

        $request = Yii::$app->request;

        if (!$request instanceof Request) {
            throw new BadMethodCallException('Unable to use non-web request.');
        }

        $path = $request->getPathInfo();

        $isActive = static fn (string $base): callable => static fn (): bool => mb_strpos($path . '/', $base . '/', 0, 'UTF-8') === 0;

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
