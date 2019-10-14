<?php

namespace app\components\category\behaviors;

use CActiveRecord;
use CActiveRecordBehavior;
use CDbCommand;
use CDbCommandBuilder;
use CDbCriteria;
use CDbTableSchema;
use Yii;

/**
 * @property string $urlAttribute
 * @property string $titleAttribute
 * @property string $aliasAttribute
 * @property string $linkActiveAttribute
 * @property string $requestPathAttribute
 *
 * @property integer[] $array
 * @property mixed $assocList
 * @property mixed $aliasList
 * @property mixed $menuList
 */
class CategoryBehavior extends CActiveRecordBehavior
{
    /**
     * @var string model attribute used for showing title
     */
    public $titleAttribute = 'title';
    /**
     * @var string model attribute, which defined alias
     */
    public $aliasAttribute = 'alias';
    /**
     * @var string model property, which contains url.
     * Optionally your model can have 'url' attribute or getUrl() method,
     * which construct correct url for using our getMenuList().
     */
    public $urlAttribute = 'url';
    /**
     * @var string model property, which contains icon.
     * Optionally for 'image' value your model can have 'image' attribute or getImage() method,
     * which construct correct url for using our getMenuList().
     */
    public $iconAttribute;
    /**
     * @var string model property, which return true for active menu item.
     * Optionally declare own getLinkActive() method in your model.
     */
    public $linkActiveAttribute = 'linkActive';
    /**
     * @var string set this request property if you can use default getLinkActive() method
     */
    public $requestPathAttribute = 'path';
    /**
     * @var array default criteria for all queries
     */
    public $defaultCriteria = [];

    protected $_primaryKey;
    protected $_tableSchema;
    protected $_tableName;
    protected $_criteria;

    public function getArray(): array
    {
        $criteria = $this->getOwnerCriteria();
        $criteria->select = $this->primaryKeyAttribute;

        $command = $this->createFindCommand($criteria);
        $result = $command->queryColumn();
        $this->clearOwnerCriteria();
        return $result;
    }

    /**
     * Returns associated array ($id=>$title, $id=>$title, ...)
     * @return array
     */
    public function getAssocList(): array
    {
        $this->cached();

        $items = $this->getFullAssocData([
            $this->primaryKeyAttribute,
            $this->titleAttribute,
        ]);

        $result = [];
        foreach ($items as $item) {
            $result[$item[$this->primaryKeyAttribute]] = $item[$this->titleAttribute];
        }

        return $result;
    }

    /**
     * Returns associated array ($alias=>$title, $alias=>$title, ...)
     * @return array
     */
    public function getAliasList(): array
    {
        $this->cached();

        $items = $this->getFullAssocData([
            $this->aliasAttribute,
            $this->titleAttribute,
        ]);

        $result = [];
        foreach ($items as $item) {
            $result[$item[$this->aliasAttribute]] = $item[$this->titleAttribute];
        }

        return $result;
    }

    /**
     * Returns associated array ($url=>$title, $url=>$title, ...)
     * @return array
     */
    public function getUrlList(): array
    {
        $criteria = $this->getOwnerCriteria();

        $items = $this->cached($this->getOwner())->findAll($criteria);

        $result = [];

        foreach ($items as $item) {
            $result = $result + [$item->{$this->urlAttribute} => $item->{$this->titleAttribute}];
        }

        return $result;
    }

    public function getMenuList(): array
    {
        $criteria = $this->getOwnerCriteria();

        $items = $this->cached($this->getOwner())->findAll($criteria);

        $result = [];

        foreach ($items as $item) {
            $active = $item->{$this->linkActiveAttribute};
            $result[$item->getPrimaryKey()] = [
                'id' => $item->getPrimaryKey(),
                'label' => $item->{$this->titleAttribute},
                'url' => $item->{$this->urlAttribute},
                'icon' => $this->iconAttribute !== null ? $item->{$this->iconAttribute} : '',
                'active' => $active,
                'itemOptions' => ['class' => 'item_' . $item->getPrimaryKey()],
                'linkOptions' => $active ? ['rel' => 'nofollow'] : [],
            ];
        }

        return $result;
    }

    public function findByAlias(string $alias): ?CActiveRecord
    {
        $model = $this->cached($this->getOwner())->find([
            'condition' => 't.' . $this->aliasAttribute . '=:alias',
            'params' => [':alias' => $alias],
        ]);
        return $model;
    }

    /**
     * Optional redeclare this method in your model for use getMenuList()
     * or define in requestPathAttribute your $_GET attribute for url matching
     * @return bool true if current request url matches with category alias
     */
    public function getLinkActive(): bool
    {
        return mb_strpos(Yii::app()->request->getParam($this->requestPathAttribute), $this->getOwner()->{$this->aliasAttribute}, null, 'UTF-8') === 0;
    }

    /**
     * Redeclare this method in your model for use of getMenuList() method
     * @return string
     */
    public function getUrl(): string
    {
        return '#';
    }

    protected function getFullAssocData(array $attributes): array
    {
        $criteria = $this->getOwnerCriteria();

        $attributes = $this->aliasAttributes(array_unique(array_merge($attributes, [$this->primaryKeyAttribute])));
        $criteria->select = implode(', ', $attributes);

        $command = $this->createFindCommand($criteria);
        $this->clearOwnerCriteria();
        return $command->queryAll();
    }

    protected function createFindCommand($criteria): CDbCommand
    {
        $builder = new CDbCommandBuilder(Yii::app()->db->getSchema());
        return $builder->createFindCommand($this->tableName, $criteria);
    }

    protected function cached(CActiveRecord $model = null): CActiveRecord
    {
        if ($model === null) {
            $model = $this->getOwner();
        }

        $connection = $model->getDbConnection();
        return $model->cache($connection->queryCachingDuration);
    }

    protected function aliasAttributes(array $attributes): array
    {
        $aliasesAttributes = [];
        foreach ($attributes as $attribute) {
            $aliasesAttributes[] = 't.' . $attribute;
        }
        return $aliasesAttributes;
    }

    protected function getPrimaryKeyAttribute(): ?string
    {
        if ($this->_primaryKey === null) {
            $this->_primaryKey = $this->tableSchema->primaryKey;
        }
        return $this->_primaryKey;
    }

    protected function getTableSchema(): CDbTableSchema
    {
        if ($this->_tableSchema === null) {
            $this->_tableSchema = $this->getOwner()->getMetaData()->tableSchema;
        }
        return $this->_tableSchema;
    }

    protected function getTableName(): string
    {
        if ($this->_tableName === null) {
            $this->_tableName = $this->getOwner()->tableName();
        }
        return $this->_tableName;
    }

    protected function getOwnerCriteria(): CDbCriteria
    {
        $criteria = clone $this->getOwner()->getDbCriteria();
        $criteria->mergeWith($this->defaultCriteria);
        $this->_criteria = clone $criteria;
        return $criteria;
    }

    protected function clearOwnerCriteria(): void
    {
        $this->getOwner()->setDbCriteria(new CDbCriteria());
    }

    protected function getOriginalCriteria(): CDbCriteria
    {
        return clone $this->_criteria;
    }
}
