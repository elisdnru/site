<?php

Yii::import('application.modules.config.models.*');
Yii::import('application.modules.blog.models.*');

class BlogCategoryTest extends DbTestCase
{
    /**
     * @var BlogCategory
     */
    protected $category;

    public $fixtures = [
        'config'=>'Config',
        'blog_post'=>'BlogPost',
        'blog_category'=>'BlogCategory',
        'blog_postGroup'=>'BlogPostGroup',
        'new_gallery'=>'NewsGallery',
        'user'=>'User',
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->category = new BlogCategory();
    }

    public function testTitleIsRequired()
    {
        $this->category->title = '';
        $this->assertFalse($this->category->validate(['title']));
    }

    public function testAliasIsRequired()
    {
        $this->category->alias = '';
        $this->assertFalse($this->category->validate(['alias']));
    }

    public function testAliasSymbols()
    {
        foreach ($this->normalAliases as $alias) {
            $this->category->alias = $alias;
            $this->assertTrue($this->category->validate(['alias']), 'Alias ' . $alias);
        }

        foreach ($this->failAliases as $alias) {
            $this->category->alias = $alias;
            $this->assertFalse($this->category->validate(['alias']), 'Alias ' . $alias);
        }
    }

    public function testTitleMaxLength()
    {
        $this->category->title = str_repeat('q', 256);
        $this->assertFalse($this->category->validate(['title']));

        $this->category->title = str_repeat('q', 255);
        $this->assertTrue($this->category->validate(['title']));
    }

    public function testParentIdIsExist()
    {
        $this->category->parent_id = 0;
        $this->assertTrue($this->category->validate(['parent_id']), 'Empty parent');

        $this->category->parent_id = 1;
        $this->assertTrue($this->category->validate(['parent_id']), 'Existing parent');

        $this->category->parent_id = 100;
        $this->assertFalse($this->category->validate(['parent_id']), 'Other parent');
    }

    public function testParentRelation()
    {
        $category = $this->blog_category('child_category');
        $this->assertInstanceOf('BlogCategory', $category->parent);
    }

    public function testPostsCountRelation()
    {
        $category = $this->blog_category('category_with_posts');
        $this->assertEquals(3, $category->posts_count);

        $category = $this->blog_category('category_without_posts');
        $this->assertEquals(0, $category->posts_count);
    }

    public function testPostsRelation()
    {
        $category = $this->blog_category('category_with_posts');
        $this->assertEquals(3, count($category->posts));

        $category = $this->blog_category('category_without_posts');
        $this->assertEquals(0, count($category->posts));
    }

    public function testChildRelation()
    {
        $category = $this->blog_category('parent_category');
        $this->assertEquals(1, count($category->child_items));

        $category = $this->blog_category('child_category');
        $this->assertEquals(0, count($category->child_items));
    }

    public function testPublicItemsCountRelation()
    {
        $category = $this->blog_category('category_with_posts');
        $this->assertEquals(1, $category->items_count);

        $category = $this->blog_category('category_without_posts');
        $this->assertEquals(0, $category->items_count);
    }
}
