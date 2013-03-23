<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DImageLinkColumn extends DLinkColumn
{
    public $width = 0;
    public $height = 0;

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data)
    {
        $url = $this->getItemUrl($data, $row);
        $value = $this->getItemValue($data, $row);

        $options = $this->getImageOptions();
        $image = CHtml::image($value, '', $options);

        echo $value===null ? $this->grid->nullDisplay : CHtml::link($image, $url);
    }

    protected function getImageOptions()
    {
        $options = array();

        if ($this->width)
            $options['width'] = $this->width;
        if ($this->height)
            $options['height'] = $this->height;

        return $options;
    }
}
