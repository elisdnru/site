<?php

declare(strict_types=1);

namespace app\modules\comment\models;

use app\components\ForceActiveRecordErrors;
use app\components\Gravatar;
use app\modules\user\models\User;
use LogicException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\mail\MailerInterface;
use yii\web\Session;

/**
 * @property int $id
 * @property string $type
 * @property int $material_id
 * @property string $date
 * @property int $user_id
 * @property string|null $name
 * @property string $email
 * @property string|null $site
 * @property string $text
 * @property int $public
 * @property int $moder
 * @property int|null $parent_id
 * @property Comment[] $children
 * @property int $likes
 * @property User|null $user
 * @property Comment|null $parent
 * @property Material $material
 */
final class Comment extends ActiveRecord
{
    use ForceActiveRecordErrors;

    private ?string $cachedUrl = null;

    /**
     * @var string[]
     */
    private array $cachedAvatarUrl = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public static function tableName(): string
    {
        return 'comments';
    }

    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function getChildren(): ActiveQuery
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getMaterial(): ActiveQuery
    {
        return $this->hasOne($this->type, ['id' => 'material_id']);
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
        return new CommentQuery(self::class);
    }

    public function behaviors(): array
    {
        return [
            'Timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'date',
                'updatedAtAttribute' => null,
                'value' => static fn () => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if (!$this->type) {
                throw new LogicException('Unable to save comment without type.');
            }
            return true;
        }
        return false;
    }

    public function sendNotifications(MailerInterface $mailer): void
    {
        if ($this->parent && $this->parent->email !== $this->email) {
            $this->parent->sendNotify($this, $mailer);
        }
    }

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = $this->material->getCommentUrl() . '#comment_' . $this->id;
        }

        return $this->cachedUrl;
    }

    public function getAvatarUrl(int $width = 100, int $height = 100): string
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

    public function toggleLike(Session $session): void
    {
        if (!$this->getLiked($session)) {
            ++$this->likes;
            $session->set('comment-like-' . $this->id, true);
        } else {
            --$this->likes;
            $session->set('comment-like-' . $this->id, false);
        }
    }

    public function getLiked(Session $session): bool
    {
        return $session->get('comment-like-' . $this->id) === true;
    }

    private function sendNotify(self $current, MailerInterface $mailer): void
    {
        if ($this->email !== $current->email) {
            $mailer
                ->compose(['html' => '@app/modules/comment/views/email/comment'], [
                    'comment' => $this,
                    'current' => $current,
                ])
                ->setSubject('Новый комментарий на сайте elisdn.ru')
                ->setTo($this->email)
                ->send();
        }
    }
}
