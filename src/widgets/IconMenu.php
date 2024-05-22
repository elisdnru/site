<?php

declare(strict_types=1);

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\Menu;

final class IconMenu extends Menu
{
    public string $iconsPath = '';

    protected function renderItem($item): string
    {
        /**
         * @psalm-var array{icon?: string, label: string, url?: array, linkOptions: array} $item
         */
        $icon = isset($item['icon']) ? Html::img($this->iconsPath . $item['icon'], ['alt' => $item['label']]) : '';
        $options = $item['linkOptions'] ?? [];

        if (isset($item['url'])) {
            $label = $item['label'];

            return $icon . Html::a($label, $item['url'], $options);
        }

        return $icon . Html::tag('span', $item['label'], $options);
    }
}
