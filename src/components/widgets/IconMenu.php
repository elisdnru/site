<?php

namespace app\components\widgets;

use CHtml;
use CMenu;
use Yii;

Yii::import('zii.widgets.CMenu');

/**
 * DIconMenu
 *
 * <pre>
 * <?php $this->widget(\DIconMenu::class, array(
 *     'iconPath'=>'/icons/',
 *     'items'=>array(
 *         array(
 *             'label'=>'Home',
 *             'url'=>array('site/index'),
 *             'icon'=>'nome.png'
 *         ),
 *     ),
 * )); ?>
 * </pre>
 *
 * <li><img src="/icons/home.png" alt="Home" /><a href="/">Home</a></li>
 */
class IconMenu extends CMenu
{
    public $iconsPath = '';

    protected function renderMenuItem($item)
    {
        $icon = !empty($item['icon']) ? CHtml::image($this->iconsPath . $item['icon'], $item['label']) : '';
        $options = $item['linkOptions'] ?? [];

        if (isset($item['url'])) {
            if ($this->linkLabelWrapper !== null) {
                $label = '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';
            } else {
                $label = $item['label'];
            }

            return $icon . CHtml::link($label, $item['url'], $options);
        }

        return $icon . CHtml::tag('span', $options, $item['label']);
    }
}