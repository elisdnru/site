<?php

declare(strict_types=1);

namespace app\modules\page\forms\admin;

use app\components\SlugValidator;
use app\modules\page\models\Page;
use Override;
use yii\base\Model;

final class PageForm extends Model
{
    public string $slug = '';
    public string $title = '';
    public int|string $hidetitle = '';
    public string $meta_title = '';
    public string $meta_description = '';
    public string $robots = '';
    public string $styles = '';
    public string $text = '';
    public string $layout = '';
    public string $subpages_layout = '';
    public null|int|string $parent_id = null;
    public int|string $system = '';

    private ?Page $page = null;

    public function __construct(?Page $page = null, array $config = [])
    {
        parent::__construct($config);

        if ($page !== null) {
            $this->slug = $page->slug;
            $this->title = $page->title;
            $this->hidetitle = (int)$page->hidetitle;
            $this->meta_title = $page->meta_title;
            $this->meta_description = $page->meta_description;
            $this->robots = $page->robots;
            $this->styles = $page->styles;
            $this->text = $page->text;
            $this->layout = $page->layout;
            $this->subpages_layout = $page->subpages_layout;
            $this->parent_id = $page->parent_id;
            $this->system = (int)$page->system;

            $this->page = $page;
        }
    }

    #[Override]
    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            ['slug', SlugValidator::class],
            [['slug', 'title', 'meta_title', 'robots', 'layout', 'subpages_layout'], 'string', 'max' => 255],
            [['hidetitle', 'parent_id'], 'integer'],
            [['date', 'styles', 'text', 'meta_description', 'system'], 'safe'],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'layout' => 'Шаблон страницы',
            'layout_list_id' => 'Шаблон списка новостей',
            'layout_item_id' => 'Шаблон страницы новости',
            'layout_item_content_id' => 'Шаблон контента новости',
            'subpages_layout' => 'Вид списка дочерних страниц',
            'slug' => 'URL транслитом',
            'date' => 'Дата создания',
            'title' => 'Заголовок',
            'hidetitle' => 'Скрыть заголовок',
            'meta_title' => 'Заголовок окна',
            'meta_description' => 'Описание',
            'robots' => 'Индексация (robots)',
            'system' => 'Системная',
            'styles' => 'CSS стили',
            'text' => 'Текст',
            'parent_id' => 'Родительская страница',
        ];
    }

    public function getAvailableParentList(): array
    {
        return $this->page && $this->page->parent_id
            ? array_diff_key(Page::find()->getTabList(), Page::find()->getAssocList($this->page->id))
            : Page::find()->getTabList();
    }

    public function getAvailableLayoutList(): array
    {
        return Page::LAYOUTS;
    }

    public function getAvailableSubPagesLayoutList(): array
    {
        return Page::SUBPAGES_LAYOUTS;
    }
}
