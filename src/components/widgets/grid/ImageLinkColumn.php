<?php

namespace app\components\widgets\grid;

use CHtml;

class ImageLinkColumn extends LinkColumn
{
    public $width = 0;
    public $height = 0;

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {
        $url = $this->getItemUrl($row, $data);
        $value = $this->getItemValue($row, $data);

        $options = $this->getImageOptions();
        $image = CHtml::image($value, '', $options);

        echo $value === null ? $this->grid->nullDisplay : CHtml::link($image, $url);
    }

    protected function getImageOptions()
    {
        $options = [];

        if ($this->width) {
            $options['width'] = $this->width;
        }
        if ($this->height) {
            $options['height'] = $this->height;
        }

        return $options;
    }
}