<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DIndentLinkColumn extends DLinkColumn
{
    public $indent = '$data->indent';

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row,$data)
    {
        $url = $this->getItemUrl($row, $data);
        $value = $this->getItemValue($row, $data);
        $indent = $this->getItemIndent($data, $row);
        $spacer = str_repeat('&nbsp;', $indent * 4);
        $text = $this->grid->getFormatter()->format($value, $this->type);
        echo $value === null ? $this->grid->nullDisplay : $spacer . CHtml::link($text, $url);
    }

    protected function getItemIndent($data, $row)
    {
        if (!empty($this->indent))
            return $this->evaluateExpression($this->indent, array('data' => $data, 'row' => $row));

        return 0;
    }
}