<?php

Yii::import('application.modules.user.models.*');
Yii::import('application.modules.blog.models.BlogPostComment');

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
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
class Comment extends CActiveRecord
{
    protected $type_of_comment = '';
    protected $lang_of_system = '';

    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
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

    public function fixedText($attribute, $options)
    {
        $this->$attribute = preg_replace('#\r\n#s', "\n", trim($this->$attribute));
        $this->$attribute = preg_replace('#([^\n])\n?<pre\>#s', "$1\n\n<pre>", $this->$attribute);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
            'parent' => [self::BELONGS_TO, 'Comment', 'parent_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
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
    public function search()
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

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.public=1',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'CTimestamp' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date',
                'updateAttribute' => null,
                'setUpdateOnCreate' => false,
            ],
            'PurifyText' => [
                'class' => 'DPurifyTextBehavior',
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

    protected function instantiate($attributes)
    {
        $class = $attributes['type'] . 'Comment';
        $model = new $class(null);
        return $model;
    }

    // scope
    public function material($id)
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
    public function type($type)
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

    public function findAll($condition = '', $params = [])
    {
        $this->type($this->type_of_comment);
        return parent::findAll($condition, $params);
    }

    public function findAllByAttributes($attributes, $condition = '', $params = [])
    {
        $this->type($this->type_of_comment);
        return parent::findAllByAttributes($attributes, $condition, $params);
    }

    public function count($condition = '', $params = [])
    {
        $this->type($this->type_of_comment);
        return parent::count($condition, $params);
    }

    protected function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->initType();
            return true;
        }
        return false;
    }

    protected function beforeSave()
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

    private function fillDefaultValues()
    {
        if ($this->cache(0)->user) {
            $this->email = $this->user->email;
            $this->name = trim($this->user->name . ' ' . $this->user->lastname);
            $this->site = $this->user->site;
        }
    }

    private function initType()
    {
        if (!$this->type) {
            $this->type = $this->type_of_comment;
        }
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $this->sendNotifications();
        }

        $this->updateMaterial();
        $this->updateAuthor();
        parent::afterSave();
    }

    protected function afterDelete()
    {
        $this->updateMaterial();
        parent::afterDelete();
    }

    private function sendNotifications()
    {
        if ($this->parent && $this->parent->email != $this->email) {
            $this->parent->sendNotify($this);
        }
    }

    private function sendNotify($current)
    {
        if ($this->email != $current->email) {
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

    private function updateMaterial()
    {
        if ($this->type && $this->material instanceof DICommentDepends) {
            $this->material->updateCommentsState($this);
        }
    }


    private function updateAuthor()
    {
        if ($this->user) {
            $this->user->updateCommentsStat();
        }
    }

    private $_url;

    public function getUrl()
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
                $this->_avatarUrl[$index] = DGRavatarHelper::get($this->email, $width);
            }
        }
        return $this->_avatarUrl[$index];
    }

    public function getLiked()
    {
        $a = Yii::app()->session['comment'];
        return isset($a['liked'][$this->id]) && $a['liked'][$this->id] == 1;
    }

    public function setLiked($value)
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
