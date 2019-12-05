<?php

namespace app\widgets\grid;

use CHtml;
use yii\helpers\Html;

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
    protected function renderDataCellContent($row, $data): void
    {
        $url = $this->getItemUrl($row, $data);
        $value = $this->getItemValue($row, $data);

        $options = $this->getImageOptions();
        $image = CHtml::image($value, '', $options);

        echo $value === null ? $this->grid->nullDisplay : Html::a($image, $url);
    }

    private function getImageOptions(): array
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
