<?php

namespace app\components\widgets\grid;

use CActiveRecord;
use CDataColumn;
use CHtml;
use Yii;

class LinkColumn extends CDataColumn
{
    public $link;

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
        $text = $this->grid->getFormatter()->format($value, $this->type);
        echo $value === null ? $this->grid->nullDisplay : CHtml::link($text, $url);
    }

    protected function getItemValue(int $row, $data)
    {
        if (!empty($this->value)) {
            return $this->evaluateExpression($this->value, ['data' => $data, 'row' => $row]);
        }
        if (!empty($this->name)) {
            return CHtml::value($data, $this->name);
        }
        return null;
    }

    protected function getItemUrl(int $row, CActiveRecord $data): string
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
