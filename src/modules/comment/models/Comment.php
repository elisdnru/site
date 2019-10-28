<?php

namespace app\modules\comment\models;

use app\components\behaviors\v2\PurifyTextBehavior;
use app\components\helpers\GravatarHelper;
use app\modules\comment\models\query\CommentQuery;
use app\modules\user\models\User;
use ReflectionClass;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property Comment[] children
 * @property integer $likes
 * @property User user
 * @property Comment parent
 * @property ActiveRecord $material
 */
class Comment extends ActiveRecord
{
    public const TYPE_OF_COMMENT = null;

    /**
     * @return string the associated database table name
     */
    public static function tableName(): string
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules(): array
    {
        $anon = static function (self $model) {
            return !$model->user_id;
        };

        return [
            [['text'], 'required'],
            [['parent_id'], 'integer'],

            ['name', 'required', 'message' => 'Представьтесь', 'when' => $anon],
            ['name', 'string', 'max' => 255, 'when' => $anon],

            ['email', 'required', 'message' => 'Введите Email', 'when' => $anon],
            ['email', 'string', 'max' => 255, 'when' => $anon],
            ['email', 'email', 'when' => $anon],

            ['site', 'url', 'when' => $anon],
            ['site', 'string', 'max' => 255, 'when' => $anon],

            ['text', 'fixedText'],
        ];
    }

    public function fixedText(string $attribute): void
    {
        $this->$attribute = preg_replace('#\r\n#s', "\n", trim($this->$attribute));
        $this->$attribute = preg_replace('#([^\n])\n?<pre\>#s', "$1\n\n<pre>", $this->$attribute);
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(static::class, ['parent_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
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

    public static function find(): CommentQuery
    {
        return new CommentQuery(static::class);
    }

    public function behaviors(): array
    {
        return [
            'CTimestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => null,
                'value' => static function () {
                    return new Expression('NOW()');
                },
            ],
            'PurifyText' => [
                'class' => PurifyTextBehavior::class,
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

    public static function instantiate($row): self
    {
        $class = (new ReflectionClass($row['type']))->getNamespaceName() . '\Comment';
        return new $class(null);
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->fillDefaultValues();
            if (!$this->type) {
                $this->type = static::TYPE_OF_COMMENT;
            }
            if (!$this->type) {
                return false;
            }
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if ($this->user) {
            $this->email = $this->user->email;
            $this->name = trim($this->user->name . ' ' . $this->user->lastname);
            $this->site = $this->user->site;
        }
    }

    public function afterSave($insert, $changedAttributes): void
    {
        if ($this->isNewRecord) {
            $this->sendNotifications();
        }

        parent::afterSave($insert, $changedAttributes);
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
            Yii::$app->mailer
                ->compose(['html' => 'comment'], [
                    'comment' => $this,
                    'current' => $current,
                ])
                ->setSubject('Новый комментарий на сайте elisdn.ru')
                ->setTo($this->email)
                ->setReplyTo(Yii::app()->params['GENERAL.ADMIN_EMAIL'])
                ->send();
        }
    }

    private $cachedUrl;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = $this->material ? $this->material->getUrl() . '#comment_' . $this->id : '#';
        }

        return $this->cachedUrl;
    }

    private $cachedAvatarUrl = [];

    public function getAvatarUrl($width = User::IMAGE_WIDTH, $height = User::IMAGE_HEIGHT)
    {
        $index = $width . 'x' . $height;

        if (!isset($this->cachedAvatarUrl[$index])) {
            if ($this->user) {
                $this->cachedAvatarUrl[$index] = $this->user->getAvatarUrl($width, $height);
            } else {
                $this->cachedAvatarUrl[$index] = GravatarHelper::get($this->email, $width);
            }
        }
        return $this->cachedAvatarUrl[$index];
    }

    public function getLiked(): bool
    {
        $a = Yii::$app->session['comment'];

        return isset($a['liked'][$this->id]) && $a['liked'][$this->id] === 1;
    }

    public function setLiked(bool $value): void
    {
        $a = Yii::$app->session['comment'];

        if ($value) {
            $a['liked'][$this->id] = 1;
        } else {
            if (isset($a['liked'][$this->id])) {
                unset($a['liked'][$this->id]);
            }
        }

        Yii::$app->session['comment'] = $a;
    }
}
