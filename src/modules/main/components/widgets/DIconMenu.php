<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

Yii::import('zii.widgets.CMenu');

/**
 * DIconMenu
 *
 * <pre>
 * <?php $this->widget('DIconMenu', array(
 *     'iconPath'=>Yii::app()->request->baseUrl . '/icons/',
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
class DIconMenu extends CMenu
{
    public $iconsPath = '';

    protected function renderMenuItem($item)
    {
        $icon = !empty($item['icon']) ? CHtml::image($this->iconsPath . $item['icon'], $item['label']) : '';
        $options = isset($item['linkOptions']) ? $item['linkOptions'] : array();

        if(isset($item['url']))
        {
            if ($this->linkLabelWrapper !== null)
                $label = '<' . $this->linkLabelWrapper . '>' . $item['label'] . '</' . $this->linkLabelWrapper . '>';
            else
                $label = $item['label'];

            return $icon . CHtml::link($label, $item['url'], $options);
        }
        else
            return $icon . CHtml::tag('span', $options, $item['label']);
    }
}