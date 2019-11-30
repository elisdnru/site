<?php

namespace app\components\category\models;

use app\components\category\behaviors\CategoryBehavior;
use app\components\Transliterator;
use CActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use yii\helpers\Url;

/**
 * @property string $id
 * @property string $sort
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property string $pagetitle
 * @property string $description
 *
 * DCategoryBehavior
 * @method mixed getArray()
 * @method Category findByAlias($alias)
 * @method mixed getAssocList($parent = 0)
 * @method mixed getAliasList($parent = 0)
 * @method mixed getMenuList($sub = 0, $parent = 0)
 */
abstract class Category extends CActiveRecord
{
    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    public $urlRoute = '';

    public function rules(): array
    {
        return self::staticRules();
    }

    public static function staticRules(): array
    {
        return [
            ['alias, title', 'required'],
            ['alias', 'match', 'pattern' => '#^[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            //array('alias', 'unique', 'caseSensitive' => false, 'message' => 'Элемент с таким URL уже существует'),
            ['sort', 'numerical', 'integerOnly' => true],
            ['alias, title, pagetitle', 'length', 'max' => 255],
            ['text, description', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, sort, alias, title, text, pagetitle, description', 'safe', 'on' => 'search'],
        ];
    }

    public function attributeLabels(): array
    {
        return self::staticAttributeLabels();
    }

    public static function staticAttributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sort' => 'Позиция',
            'alias' => 'URL транслитом',
            'title' => 'Наименование',
            'text' => 'Текст',
            'pagetitle' => 'Заголовок окна',
            'description' => 'Описание',
        ];
    }

    public function search($pageSize = 10): CActiveDataProvider
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.pagetitle', $this->pagetitle, true);
        $criteria->compare('t.description', $this->description, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.sort ASC, t.title ASC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'page',
                'validateCurrentPage' => false,
            ],
        ]);
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'requestPathAttribute' => 'category',
                'defaultCriteria' => [
                    'order' => 't.sort ASC, t.title ASC'
                ],
            ],
        ];
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->alias) {
            $this->alias = Transliterator::slug($this->title);
        }
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = mb_substr(strip_tags($this->text), 0, 255, 'UTF-8');
        }
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to([$this->urlRoute, 'category' => $this->alias]);
        }

        return $this->cachedUrl;
    }
}
