<?php

declare(strict_types=1);

namespace app\modules\portfolio\forms\admin;

use app\modules\portfolio\models\Category;
use app\modules\portfolio\models\Work;
use Override;
use yii\base\Model;
use yii\web\UploadedFile;

final class WorkForm extends Model
{
    public int|string $sort = '';
    public string $date = '';
    public null|int|string $category_id = null;
    public string $slug = '';
    public string $title = '';
    public string $meta_title = '';
    public string $meta_description = '';
    public string $short = '';
    public string $text = '';
    public null|string|UploadedFile $image = '';
    public bool|string $del_image = false;
    public int|string $image_show = '';
    public int|string $public = '';

    private ?int $id = null;

    public function __construct(?Work $work = null, array $config = [])
    {
        parent::__construct($config);

        if ($work !== null) {
            $this->sort = $work->sort;
            $this->date = $work->date;
            $this->category_id = $work->category_id;
            $this->slug = $work->slug;
            $this->title = $work->title;
            $this->meta_title = $work->meta_title;
            $this->meta_description = $work->meta_description;
            $this->short = $work->short;
            $this->text = $work->text;
            $this->image_show = (int)$work->image_show;
            $this->public = (int)$work->public;

            $this->id = $work->id;
        }
    }

    #[Override]
    public function rules(): array
    {
        return [
            [['date', 'category_id', 'slug', 'title'], 'required'],
            [['sort', 'public', 'image_show'], 'integer'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['short', 'text', 'meta_description', 'del_image'], 'safe'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['title', 'slug', 'meta_title'], 'string', 'max' => '255'],
            ['slug', 'match', 'pattern' => '#^\w[a-zA-Z0-9_-]+$#s'],
            ['slug', 'unique', 'targetClass' => Work::class, 'filter' => ['!=', 'id', $this->id]],
            ['image', 'image'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'sort' => 'Порядок',
            'date' => 'Дата',
            'category_id' => 'Раздел',
            'title' => 'Заголовок',
            'slug' => 'URL транслитом',
            'meta_title' => 'Заголовок страницы',
            'meta_description' => 'Описание',
            'short' => 'Превью',
            'text' => 'Текст',
            'image' => 'Картинка для статьи',
            'del_image' => 'Удалить изображение',
            'image_show' => 'Отображать при открытии',
            'public' => 'Опубликовано',
        ];
    }

    public function getAvailableCategoryList(): array
    {
        return Category::find()->getTabList();
    }
}
