<?php

namespace app\modules\comment\models;

use app\components\purifier\PurifyTextBehavior;
use app\components\Gravatar;
use app\modules\comment\models\query\CommentQuery;
use app\modules\user\models\User;
use ReflectionClass;
use ReflectionException;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\mail\MailerInterface;
use yii\web\Session;

/**
 * @property int $id
 * @property string $type
 * @property integer $material_id
 * @property string $date
 * @property int $user_id
 * @property string|null $name
 * @property string $email
 * @property string|null $site
 * @property string $text
 * @property string $text_purified
 * @property integer $public
 * @property integer $moder
 * @property integer|null $parent_id
 * @property Comment[] $children
 * @property integer $likes
 * @property User|null $user
 * @property Comment|null $parent
 * @property Material $material
 */
class Comment extends ActiveRecord
{
    public const TYPE_OF_COMMENT = null;

    public static function tableName(): string
    {
        return 'comments';
    }

    final public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param array $row
     * @return static
     * @throws ReflectionException
     */
    public static function instantiate($row): self
    {
        /**
         * @var self $class
         * @psalm-var array{type: class-string<static>} $row
         * @psalm-var class-string<static> $class
         */
        $class = (new ReflectionClass($row['type']))->getNamespaceName() . '\Comment';
        return new $class();
    }

    public function rules(): array
    {
        $anon = static function (self $model): bool {
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
        $value = trim((string)$this->$attribute);
        $value = preg_replace('#\r\n#s', "\n", $value);
        $value = preg_replace('#([^\n])\n?<pre>#s', "$1\n\n<pre>", $value);
        $this->$attribute = $value;
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
            'Timestamp' => [
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
            $this->name = trim($this->user->firstname . ' ' . $this->user->lastname);
            $this->site = $this->user->site;
        }
    }

    public function sendNotifications(MailerInterface $mailer): void
    {
        if ($this->parent && $this->parent->email !== $this->email) {
            $this->parent->sendNotify($this, $mailer);
        }
    }

    private function sendNotify(self $current, MailerInterface $mailer): void
    {
        if ($this->email !== $current->email) {
            $mailer
                ->compose(['html' => 'comment'], [
                    'comment' => $this,
                    'current' => $current,
                ])
                ->setSubject('Новый комментарий на сайте elisdn.ru')
                ->setTo($this->email)
                ->send();
        }
    }

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = $this->material->getCommentUrl() . '#comment_' . $this->id;
        }

        return $this->cachedUrl;
    }

    /**
     * @var string[]
     */
    private array $cachedAvatarUrl = [];

    public function getAvatarUrl(int $width = User::IMAGE_WIDTH, int $height = User::IMAGE_HEIGHT): string
    {
        $index = $width . 'x' . $height;

        if (!isset($this->cachedAvatarUrl[$index])) {
            if ($this->user) {
                $this->cachedAvatarUrl[$index] = $this->user->getAvatarUrl($width, $height);
            } else {
                $this->cachedAvatarUrl[$index] = Gravatar::url($this->email, $width);
            }
        }
        return $this->cachedAvatarUrl[$index];
    }

    public function getLiked(Session $session): bool
    {
        $a = $session->get('comment');

        return isset($a['liked'][$this->id]) && $a['liked'][$this->id] === 1;
    }

    public function setLiked(bool $value, Session $session): void
    {
        $a = $session->get('comment');

        if ($value) {
            $a['liked'][$this->id] = 1;
        } else {
            if (isset($a['liked'][$this->id])) {
                unset($a['liked'][$this->id]);
            }
        }

        $session->set('comment', $a);
    }
}
