<?php

namespace app\modules\portfolio\models;

use app\components\purifier\PurifyTextBehavior;
use app\components\uploader\FileUploadBehavior;
use app\modules\portfolio\models\query\WorkQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $id
 * @property string $sort
 * @property string $date
 * @property string $category_id
 * @property string $alias
 * @property string $title
 * @property string $pagetitle
 * @property string $description
 * @property string $short
 * @property string $short_purified
 * @property string $text
 * @property string $text_purified
 * @property string $image
 * @property integer $image_width
 * @property integer $image_height
 * @property integer $image_show
 * @property integer $public
 *
 * @property Category $category
 *
 * @mixin FileUploadBehavior
 * @method Work published()
 */
class Work extends ActiveRecord
{
    public const IMAGE_WIDTH = 250;
    public const IMAGE_PATH = 'upload/images/portfolio';

    public $delImage = false;

    public static function tableName(): string
    {
        return 'portfolio_works';
    }

    public static function find(): WorkQuery
    {
        return new WorkQuery(self::class);
    }

    public function rules(): array
    {
        return [
            [['date', 'category_id', 'alias', 'title'], 'required'],
            [['sort', 'public', 'image_show'], 'integer'],
            ['category_id', 'exist', 'targetClass' => Category::class],
            [['short', 'text', 'description', 'delImage'], 'safe'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['title', 'alias', 'pagetitle'], 'string', 'max' => '255'],
            ['alias', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#s'],
            ['alias', 'unique'],
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sort' => 'Порядок',
            'date' => 'Дата',
            'category_id' => 'Раздел',
            'title' => 'Заголовок',
            'alias' => 'URL транслитом',
            'pagetitle' => 'Заголовок страницы (title)',
            'description' => 'Описание (description)',
            'short' => 'Превью',
            'text' => 'Текст',
            'image' => 'Картинка для статьи',
            'delImage' => 'Удалить изображение',
            'image_show' => 'Отображать при открытии',
            'public' => 'Опубликовано',
        ];
    }

    public function behaviors(): array
    {
        return [
            'PurifyShort' => [
                'class' => PurifyTextBehavior::class,
                'sourceAttribute' => 'short',
                'destinationAttribute' => 'short_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                ],
                'processOnBeforeSave' => true,
            ],
            'PurifyText' => [
                'class' => PurifyTextBehavior::class,
                'sourceAttribute' => 'text',
                'destinationAttribute' => 'text_purified',
                'purifierOptions' => [
                    'Attr.AllowedRel' => ['nofollow'],
                ],
                'processOnBeforeSave' => true,
            ],
            'ImageUpload' => [
                'class' => FileUploadBehavior::class,
                'fileAttribute' => 'image',
                'deleteAttribute' => 'delImage',
                'enableWatermark' => true,
                'filePath' => self::IMAGE_PATH,
                'defaultThumbWidth' => self::IMAGE_WIDTH,
                'imageWidthAttribute' => 'image_width',
                'imageHeightAttribute' => 'image_height',
            ],
        ];
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->fillDefaultValues();
            return true;
        }
        return false;
    }

    private function fillDefaultValues(): void
    {
        if (!$this->pagetitle) {
            $this->pagetitle = strip_tags($this->title);
        }
        if (!$this->description) {
            $this->description = strip_tags($this->short);
        }
    }

    public function afterSave($insert, $changedAttributes): void
    {
        if (!$this->sort) {
            $this->updateAttributes(['sort' => $this->sort = $this->id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getAssocList($only_public = false): array
    {
        if ($only_public) {
            $query = self::find()->published();
        } else {
            $query = self::find();
        }

        return $query
            ->orderBy(['date' => SORT_DESC])
            ->select(['title', 'id'])
            ->indexBy('id')->column();
    }

    public static function findByAlias($alias): ?self
    {
        return self::find()->andWhere(['alias' => $alias])->one();
    }

    private ?string $cachedUrl = null;

    public function getUrl(): string
    {
        if ($this->cachedUrl === null) {
            $this->cachedUrl = Url::to(['/portfolio/work/show', 'category' => $this->category->getPath(), 'id' => $this->getPrimaryKey(), 'alias' => $this->alias]);
        }
        return $this->cachedUrl;
    }
}
