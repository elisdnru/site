<?php

Yii::import('application.modules.blog.models.*');

class BlogPostTest extends DbTestCase {

    /**
     * @var BlogPost
     */
    protected $post;

    public $fixtures = array(
        'blog_post'=>'BlogPost',
        'blog_category'=>'BlogCategory',
        'blog_postGroup'=>'BlogPostGroup',
        'new_gallery'=>'NewsGallery',
        'user'=>'User',
    );

    protected function setUp()
    {
        parent::setUp();
        $this->post = new BlogPost();
    }

    public function testTitleIsRequired()
    {
        $this->post->title = '';
        $this->assertFalse($this->post->validate(array('title')));

        $this->post->title = 'Test title';
        $this->assertTrue($this->post->validate(array('title')));
    }

    public function testAliasIsRequired()
    {
        $this->post->alias = '';
        $this->assertFalse($this->post->validate(array('alias')));
    }

    public function testAliasSymbols()
    {
        foreach ($this->normalAliases as $alias)
        {
            $this->post->alias = $alias;
            $this->assertTrue($this->post->validate(array('alias')), 'Alias ' . $alias);
        }

        foreach ($this->failAliases as $alias)
        {
            $this->post->alias = $alias;
            $this->assertFalse($this->post->validate(array('alias')), 'Alias ' . $alias);
        }
    }

    public function testTitleMaxLength()
    {
        $this->post->title = str_repeat('s', 255);
        $this->assertTrue($this->post->validate(array('title')));
        $this->post->title = str_repeat('s', 256);
        $this->assertFalse($this->post->validate(array('title')));
    }

    public function testCreateAndUpdateDate()
    {
        $source = BlogPost::model()->findByPk(1);

        $post = new BlogPost();

        $post->attributes = $source->attributes;
        $post->alias = 'alias_create_date';
        $post->title = 'alias_create_date';
        $post->date = '';
        $post->update_date = '';

        $this->assertTrue($post->save(), 'Save model');

        $post = BlogPost::model()->findByPk($post->getPrimaryKey());

        $this->assertNotEquals('0000-00-00 00:00:00', 'First create date');
        $this->assertNotEquals('0000-00-00 00:00:00', 'First update date');

        $this->assertStringMatchesFormat('%d-%d-%d %d:%d:%d', $post->date, 'Create date format');
        $this->assertStringMatchesFormat('%d-%d-%d %d:%d:%d', $post->update_date, 'Update date format');

        $update_date = $source->update_date;

        $this->assertTrue($source->update(), 'Update model');

        $source = BlogPost::model()->findByPk($source->getPrimaryKey());

        $this->assertNotEquals($update_date, $source->update_date, 'New updated date');
    }

    public function testCategoryIdIsExist()
    {
        $this->post->category_id = 0;
        $this->assertFalse($this->post->validate(array('category_id')), 'Empty category');

        $this->post->category_id = 1;
        $this->assertTrue($this->post->validate(array('category_id')), 'Existing category');

        $this->post->category_id = 100;
        $this->assertFalse($this->post->validate(array('category_id')), 'Other category');
    }

    public function testAuthorIdIsExist()
    {
        $this->post->author_id = 0;
        $this->assertTrue($this->post->validate(array('author_id')), 'Empty author');

        $this->post->author_id = 1;
        $this->assertTrue($this->post->validate(array('author_id')), 'Existing author');

        $this->post->author_id = 100;
        $this->assertFalse($this->post->validate(array('author_id')), 'Other author');
    }

    public function testGalleryIdIsExist()
    {
        $this->post->gallery_id = 0;
        $this->assertTrue($this->post->validate(array('gallery_id')), 'Empty gallery');

        $this->post->gallery_id = 1;
        $this->assertTrue($this->post->validate(array('gallery_id')), 'Existing gallery');

        $this->post->gallery_id = 100;
        $this->assertFalse($this->post->validate(array('gallery_id')), 'Other gallery');
    }

    public function testGroupIdIsExist()
    {
        $this->post->group_id = 0;
        $this->assertTrue($this->post->validate(array('group_id')), 'Empty group');

        $this->post->group_id = 1;
        $this->assertTrue($this->post->validate(array('group_id')), 'Existing group');

        $this->post->group_id = 100;
        $this->assertFalse($this->post->validate(array('group_id')), 'Other group');
    }

    public function testBelongsToCategory()
    {
        $post = $this->blog_post('post_with_category');
        $this->assertInstanceOf('BlogCategory', $post->category);
    }

    public function testBelongsToAuthor()
    {
        $post = $this->blog_post('post_with_author');
        $this->assertInstanceOf('User', $post->author);
    }

    public function testBelongsToGallery()
    {
        $post = $this->blog_post('post_with_gallery');
        $this->assertInstanceOf('NewsGallery', $post->gallery);
    }

    public function testBelongsToGroup()
    {
        $post = $this->blog_post('post_with_group');
        $this->assertInstanceOf('BlogPostGroup', $post->group);
    }

    public function testSafeAttributesOnSearchScenario()
    {
        $category = new BlogPost('search');

        $mustBeSafe = array(
            'id',
            'date',
            'category_id',
            'author_id',
            'title',
            'text',
            'public',
            'gallery_id',
            'group_id',
        );

        $safeAttrs = $category->safeAttributeNames;

        sort($mustBeSafe); sort($safeAttrs);

        $this->assertGreaterThanOrEqual($mustBeSafe, $safeAttrs);
    }
}