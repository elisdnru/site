<?php

namespace app\widgets\grid;

use yii\helpers\Html;

class IndentLinkColumn extends LinkColumn
{
    public $indent = null;

    public function __construct($grid)
    {
        $this->indent = static function ($data) {
            return $data->indent;
        };

        parent::__construct($grid);
    }

    protected function renderDataCellContent($row, $data): void
    {
        $url = $this->getItemUrl($row, $data);
        $value = $this->getItemValue($row, $data);
        $indent = $this->getItemIndent($data, $row);
        $spacer = str_repeat('&nbsp;', $indent * 4);
        $text = $this->grid->getFormatter()->format($value, $this->type);
        echo $value === null ? $this->grid->nullDisplay : $spacer . Html::a($text, $url);
    }

    private function getItemIndent($data, int $row): int
    {
        if (!empty($this->indent)) {
            return $this->evaluateExpression($this->indent, ['data' => $data, 'row' => $row]);
        }

        return 0;
    }
}
