<?php

namespace app\components\validators\v2;

use CDbCriteria;
use CException;
use CExistValidator;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

class ExistOrEmpty extends CExistValidator
{
    protected function isEmpty($value, $trim = false): bool
    {
        return !$value || parent::isEmpty($value, $trim);
    }

    protected function validateAttribute($object, $attribute): void
    {
        $value = $object->$attribute;
        if ($this->allowEmpty && $this->isEmpty($value)) {
            return;
        }

        if (is_array($value)) {
            // https://github.com/yiisoft/yii/issues/1955
            $this->addError($object, $attribute, Yii::t('yii', '{attribute} is invalid.'));
            return;
        }

        /** @var ActiveRecord $className */
        $className = $this->className ?: get_class($object);
        $attributeName = $this->attributeName === null ? $attribute : $this->attributeName;
        $table = $className::getTableSchema();
        if (($column = $table->getColumn($attributeName)) === null) {
            throw new CException(Yii::t(
                'yii',
                'Table "{table}" does not have a column named "{column}".',
                ['{column}' => $attributeName, '{table}' => $table->name]
            ));
        }

        $columnName = $column->name;
        $valueParamName = CDbCriteria::PARAM_PREFIX . CDbCriteria::$paramCount++;
        $query = $className::find()
            ->andWhere($this->caseSensitive ? new Expression("$columnName= $valueParamName") : new Expression("LOWER({$columnName})=LOWER({$valueParamName})"))
            ->addParams([$valueParamName => $value]);

        if (!$query->exists()) {
            $message = $this->message !== null ? $this->message : Yii::t('yii', '{attribute} "{value}" is invalid.');
            $this->addError($object, $attribute, $message, ['{value}' => $value]);
        }
    }
}
