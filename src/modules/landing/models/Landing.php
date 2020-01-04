<?php

namespace app\modules\landing\models;

use app\components\category\behaviors\CategoryTreeBehavior;
use app\components\category\TreeActiveDataProvider;
use CActiveRecord;
use CDbCriteria;
use yii\helpers\Url;

/**
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $text
 * @property integer $parent_id
 * @property integer $system
 *
 * @property Landing[] $children
 *
 * @mixin CategoryTreeBehavior
 */
class Landing extends CActiveRecord
{
    public $indent = 0;

    /**
     * @param string|null $className
     * @return CActiveRecord|static
     */
    public static function model($className = null): self
    {
        return parent::model($className ?: static::class);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'landings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['alias, title', 'required'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#', 'message' => 'Допустимы только латинские символы, цифры и знак подчёркивания'],
            ['alias, title', 'length', 'max' => 255],
            ['parent_id', 'numerical', 'integerOnly' => true],
            ['text, system', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, alias, title, text', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
            'children' => [self::HAS_MANY, self::class, 'parent_id',
                'order' => 'children.id ASC'
            ],
            'children_count' => [self::STAT, self::class, 'parent_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'alias' => 'URL транслитом',
            'title' => 'Заголовок',
            'system' => 'Системный',
            'text' => 'Текст',
            'parent_id' => 'Родительский лендинг',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @param int $pageSize
     * @return TreeActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($pageSize = 10): TreeActiveDataProvider
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.text', $this->text, true);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.system', $this->system);

        return new TreeActiveDataProvider($this, [
            'criteria' => $criteria,
            'childRelation' => 'children',
            'sort' => [
                'defaultOrder' => 't.alias ASC',
            ],
            'pagination' => [
                'pageSize' => $pageSize,
                'pageVar' => 'landing',
            ],
        ]);
    }

    public function behaviors(): array
    {
        return [
            'CategoryBehavior' => [
                'class' => CategoryTreeBehavior::class,
                'titleAttribute' => 'title',
                'aliasAttribute' => 'alias',
                'parentAttribute' => 'parent_id',
                'linkActiveAttribute' => 'linkActive',
                'parentRelation' => 'parent',
                'defaultCriteria' => [
                    'order' => 't.parent_id ASC, t.title ASC',
                ],
            ],
        ];
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/landing/landing/show', 'path' => $this->getPath()]);
        }
        return $this->cachedUrl;
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            if (!$this->parent_id) {
                $this->parent_id = null;
            }
            return true;
        }
        return false;
    }

    protected function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            $this->delChildLandings();
            return true;
        }
        return false;
    }

    private function delChildLandings(): void
    {
        foreach ($this->children as $child) {
            $child->delete();
        }
    }
}
