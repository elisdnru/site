<?php

namespace app\components\widgets\grid;

use CDataColumn;
use CHtml;
use Yii;

Yii::import('zii.widgets.grid.CDataColumn');

class LinkColumn extends CDataColumn
{
    public $link;

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
        $text = $this->grid->getFormatter()->format($value, $this->type);
        echo $value === null ? $this->grid->nullDisplay : CHtml::link($text, $url);
    }

    protected function getItemValue($row, $data)
    {
        if (!empty($this->value)) {
            return $this->evaluateExpression($this->value, ['data' => $data, 'row' => $row]);
        }
        if (!empty($this->name)) {
            return CHtml::value($data, $this->name);
        }
        return null;
    }

    protected function getItemUrl($row, $data)
    {
        if (!empty($this->link)) {
            return $this->evaluateExpression($this->link, ['data' => $data, 'row' => $row]);
        }
        if ($this->link !== false) {
            return Yii::app()->controller->createUrl('update', ['id' => $data->getPrimaryKey()]);
        }
        return '';
    }
}