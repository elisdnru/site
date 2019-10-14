<?php

namespace app\modules\comment\models;

use app\components\ActiveRecord;
use app\modules\comment\components\CommentDepends;
use app\components\helpers\GravatarHelper;
use CActiveDataProvider;
use CDbCriteria;
use app\modules\user\models\User;
use Yii;

/**
 * @property string $id
 * @property string $type
 * @property integer $material_id
 * @property string $date
 * @property string $user_id
 * @property string $name
 * @property string $email
 * @property string $site
 * @property string $text
 * @property string $text_purified
 * @property integer $public
 * @property integer $moder
 * @property integer $parent_id
 */
class Comment extends ActiveRecord
{
    protected $type_of_comment = '';
    protected $lang_of_system = '';

    /**
     * @return string the associated database table name
     */
    public function tableName(): string
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['material_id, type, text', 'required'],
            ['user_id, parent_id', 'numerical', 'integerOnly' => true],
            ['material_id, user_id, type', 'unsafe'],

            ['name', 'length', 'max' => 255],
            ['name', 'required', 'message' => 'Представьтесь', 'on' => 'anonim'],

            ['email', 'length', 'max' => 255],
            ['email', 'email', 'message' => 'Неверный формат Email адреса'],
            ['email', 'required', 'message' => 'Введите Email', 'on' => 'anonim'],

            ['site', 'url'],
            ['site', 'length', 'max' => 255],

            ['text', 'fixedText'],

            ['id, material_id, type, date, user_id, parent_id, text, public, moder', 'safe', 'on' => 'search'],
        ];
    }

    public function fixedText(string $attribute): void
    {
        $this->$attribute = preg_replace('#\r\n#s', "\n", trim($this->$attribute));
        $this->$attribute = preg_replace('#([^\n])\n?<pre\>#s', "$1\n\n<pre>", $this->$attribute);
    }

    /**
     * @return array relational rules.
     */
    public function relations(): array
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'user' => [self::BELONGS_TO, \app\modules\user\models\User::class, 'user_id'],
            'parent' => [self::BELONGS_TO, self::class, 'parent_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'parent_id' => 'ID родителя',
            'material_id' => 'Материал',
            'date' => 'Дата',
            'user_id' => 'Автор',
            'name' => 'Имя',
            'email' => 'Email',
            'site' => 'Сайт',
            'text' => 'Текст',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search(): CActiveDataProvider
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        if ($this->type_of_comment) {
            $criteria->compare('type', $this->type_of_comment);
        } else {
            $criteria->compare('type', $this->type);
        }
        $criteria->compare('material_id', $this->material_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('site', $this->site, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('public', $this->public);
        $criteria->compare('moder', $this->moder);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public function scopes(): array
    {
        return [
            'published' => [
                'condition' => 't.public=1',
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            'CTimestamp' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date',
                'updateAttribute' => null,
                'setUpdateOnCreate' => false,
            ],
            'PurifyText' => [
                'class' => \app\components\behaviors\PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'encodePreContent' => true,
                'purifierOptions' => [
                    'AutoFormat.AutoParagraph' => true,
                    'HTML.Allowed' => 'p,ul,li,b,i,a[href],pre',
                    'AutoFormat.Linkify' => true,
                    'HTML.Nofollow' => true,
                    'Core.EscapeInvalidTags' => true,
                ],
                'processOnBeforeSave' => true,
            ]
        ];
    }

    protected function instantiate($attributes): self
    {
        $class = (new \ReflectionClass($attributes['type']))->getNamespaceName() . '\Comment';
        return new $class(null);
    }

    // scope
    public function material($id): self
    {
        if ($id) {
            $this->getDbCriteria()->mergeWith([
                'condition' => 'material_id=:id',
                'params' => [':id' => $id],
            ]);
        }
        return $this;
    }

    // scope
    public function type($type): self
    {
        if ($type) {
            $this->getDbCriteria()->mergeWith([
                'condition' => 'type=:type',
                'params' => [':type' => $type],
            ]);
        }
        return $this;
    }

    public function find($condition = '', $params = [])
    {
        $this->type($this->type_of_comment);
        return parent::find($condition, $params);
    }

    public function findAll($condition = '', $params = []): array
    {
        $this->type($this->type_of_comment);
        return parent::findAll($condition, $params);
    }

    public function findAllByAttributes($attributes, $condition = '', $params = []): array
    {
        $this->type($this->type_of_comment);
        return parent::findAllByAttributes($attributes, $condition, $params);
    }

    public function count($condition = '', $params = []): int
    {
        $this->type($this->type_of_comment);
        return parent::count($condition, $params);
    }

    protected function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->initType();
            return true;
        }
        return false;
    }

    protected function beforeSave(): bool
    {
        if (parent::beforeSave()) {
            $this->fillDefaultValues();
            $this->initType();
            if (!$this->type) {
                return false;
            }
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if ($this->cache(0)->user) {
            $this->email = $this->user->email;
            $this->name = trim($this->user->name . ' ' . $this->user->lastname);
            $this->site = $this->user->site;
        }
    }

    private function initType(): void
    {
        if (!$this->type) {
            $this->type = $this->type_of_comment;
        }
    }

    protected function afterSave(): void
    {
        if ($this->isNewRecord) {
            $this->sendNotifications();
        }

        $this->updateMaterial();
        $this->updateAuthor();
        parent::afterSave();
    }

    protected function afterDelete(): void
    {
        $this->updateMaterial();
        parent::afterDelete();
    }

    private function sendNotifications(): void
    {
        if ($this->parent && $this->parent->email !== $this->email) {
            $this->parent->sendNotify($this);
        }
    }

    private function sendNotify($current): void
    {
        if ($this->email !== $current->email) {
            $email = Yii::app()->email;
            $email->to = $this->email;
            $email->replyTo = Yii::app()->params['GENERAL.ADMIN_EMAIL'];
            $email->subject = 'Новый комментарий на сайте ' . $_SERVER['SERVER_NAME'];
            $email->message = '';
            $email->view = 'comment/comment';
            $email->viewVars = [
                'comment' => $this,
                'current' => $current,
            ];
            $email->send();
        }
    }

    private function updateMaterial(): void
    {
        if ($this->type && $this->material instanceof CommentDepends) {
            $this->material->updateCommentsState($this);
        }
    }


    private function updateAuthor(): void
    {
        if ($this->user) {
            $this->user->updateCommentsStat();
        }
    }

    private $_url;

    public function getUrl(): string
    {
        if ($this->_url === null) {
            $this->_url = $this->material ? $this->material->url . '#comment_' . $this->id : '#';
        }

        return $this->_url;
    }

    private $_avatarUrl = [];

    public function getAvatarUrl($width = User::IMAGE_WIDTH, $height = User::IMAGE_HEIGHT)
    {
        $index = $width . 'x' . $height;

        if (!isset($this->_avatarUrl[$index])) {
            if ($this->cache(1000)->user) {
                $this->_avatarUrl[$index] = $this->user->getAvatarUrl($width, $height);
            } else {
                $this->_avatarUrl[$index] = GravatarHelper::get($this->email, $width);
            }
        }
        return $this->_avatarUrl[$index];
    }

    public function getLiked(): bool
    {
        $a = Yii::app()->session['comment'];
        return isset($a['liked'][$this->id]) && $a['liked'][$this->id] === 1;
    }

    public function setLiked(bool $value): void
    {
        $a = Yii::app()->session['comment'];

        if ($value) {
            $a['liked'][$this->id] = '1';
        } else {
            if (isset($a['liked'][$this->id])) {
                unset($a['liked'][$this->id]);
            }
        }

        Yii::app()->session['comment'] = $a;
    }
}
