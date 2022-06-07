<?php

declare(strict_types=1);

namespace app\modules\blog\forms\admin;

use app\components\SlugValidator;
use app\modules\blog\models\Category;
use app\modules\blog\models\Group;
use app\modules\blog\models\Post;
use app\modules\blog\models\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

final class PostForm extends Model
{
    public string $date = '';
    public string|int $category_id = '';
    public string $slug = '';
    public string $title = '';
    public string $meta_title = '';
    public string $meta_description = '';
    public ?string $styles = '';
    public string $short = '';
    public string $text = '';
    public string|UploadedFile|null $image = '';
    public string $image_alt = '';
    public string|bool|int $image_show = '';
    public string|bool|int|null $group_id = null;
    public string $new_group = '';
    public string|bool|int $public = '';
    public string|bool|int $promoted = '';
    public string|bool|int $del_image = '';
    public string $tags = '';

    private int|null $id = null;

    public function __construct(?Post $post = null, array $config = [])
    {
        parent::__construct($config);

        if ($post !== null) {
            $this->id = $post->id;
            $this->date = $post->date;
            $this->category_id = $post->category_id;
            $this->slug = $post->slug;
            $this->title = $post->title;
            $this->meta_title = $post->meta_title;
            $this->meta_description = $post->meta_description;
            $this->styles = $post->styles;
            $this->short = $post->short;
            $this->text = $post->text;
            $this->image_alt = $post->image_alt;
            $this->image_show = $post->image_show;
            $this->group_id = $post->group_id;
            $this->public = $post->public;
            $this->promoted = $post->promoted;

            /** @var string[] $list */
            $list = ArrayHelper::map($post->tags, 'id', 'title');
            $this->tags = implode(', ', $list);
        }
    }

    public function rules(): array
    {
        return [
            [['category_id', 'slug', 'title'], 'required'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            ['group_id', 'exist', 'targetClass' => Group::class, 'targetAttribute' => 'id'],
            [['public', 'image_show', 'promoted'], 'integer'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['styles', 'short', 'text', 'meta_description', 'delImage'], 'safe'],
            [['title', 'slug', 'new_group', 'image_alt', 'meta_title'], 'string', 'max' => '255'],
            ['tags', 'string'],
            ['slug', SlugValidator::class],
            ['slug', 'unique', 'targetClass' => Post::class, 'filter' => ['!=', 'id', $this->id]],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'date' => 'Дата публикации',
            'category_id' => 'Раздел',
            'title' => 'Заголовок',
            'slug' => 'URL транслитом',
            'meta_title' => 'Заголовок страницы',
            'meta_description' => 'Описание',
            'styles' => 'CSS стили',
            'short' => 'Превью',
            'text' => 'Текст',
            'image' => 'Картинка для статьи',
            'delImage' => 'Удалить изображение',
            'image_alt' => 'Описание изображения',
            'image_show' => 'Отображать при открытии новости',
            'group_id' => 'Выберите тематическую группу',
            'new_group' => '...или введите имя новой',
            'public' => 'Опубликовано',
            'promoted' => 'Продвигать',
        ];
    }

    /**
     * @return array<int, string>
     */
    public function getAvailableTagsList(): array
    {
        return Tag::getAssocList();
    }

    public function getAvailableCategoriesList(): array
    {
        return Category::find()->getTabList();
    }

    public function getAvailableGroupsList(): array
    {
        return Group::find()->getAssocList();
    }

    public function getTagsArray(): array
    {
        return array_filter(array_unique(preg_split('/\s*,\s*/', $this->tags)));
    }
}
