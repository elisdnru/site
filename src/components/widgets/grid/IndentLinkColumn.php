<?php

namespace app\components\widgets\grid;

use CHtml;

class IndentLinkColumn extends LinkColumn
{
    public $indent = '$data->indent';

    protected function renderDataCellContent($row, $data): void
    {
        $url = $this->getItemUrl($row, $data);
        $value = $this->getItemValue($row, $data);
        $indent = $this->getItemIndent($data, $row);
        $spacer = str_repeat('&nbsp;', $indent * 4);
        $text = $this->grid->getFormatter()->format($value, $this->type);
        echo $value === null ? $this->grid->nullDisplay : $spacer . CHtml::link($text, $url);
    }

    protected function getItemIndent($data, int $row): int
    {
        if (!empty($this->indent)) {
            return $this->evaluateExpression($this->indent, ['data' => $data, 'row' => $row]);
        }

        return 0;
    }
}
