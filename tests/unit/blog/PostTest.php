<?php

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\modules\blog\models\Group;
use app\modules\user\models\User;

class PostTest extends DbTestCase
{
    /**
     * @var Post
     */
    protected $post;

    public $fixtures = [
        'comment'=> Comment::class,
        'blog_post'=> Post::class,
        'blog_category'=> Category::class,
        'blog_postGroup'=> Group::class,
        'user'=> User::class,
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->post = new Post();
    }

    public function testTitleIsRequired()
    {
        $this->post->title = '';
        $this->assertFalse($this->post->validate(['title']));

        $this->post->title = 'Test title';
        $this->assertTrue($this->post->validate(['title']));
    }

    public function testAliasIsRequired()
    {
        $this->post->alias = '';
        $this->assertFalse($this->post->validate(['alias']));
    }

    public function testAliasSymbols()
    {
        foreach ($this->normalAliases as $alias) {
            $this->post->alias = $alias;
            $this->assertTrue($this->post->validate(['alias']), 'Alias ' . $alias);
        }

        foreach ($this->failAliases as $alias) {
            $this->post->alias = $alias;
            $this->assertFalse($this->post->validate(['alias']), 'Alias ' . $alias);
        }
    }

    public function testTitleMaxLength()
    {
        $this->post->title = str_repeat('s', 255);
        $this->assertTrue($this->post->validate(['title']));
        $this->post->title = str_repeat('s', 256);
        $this->assertFalse($this->post->validate(['title']));
    }

    public function testCreateAndUpdateDate()
    {
        $source = Post::model()->findByPk(2);

        $update_date = $source->update_date;

        $post = new Post();

        $post->setAttributes($source->attributes, false);
        $post->id = null;
        $post->alias = 'alias_create_date';
        $post->title = 'alias_create_date';
        $post->date = '';
        $post->update_date = '';

        $this->assertTrue($post->save(), 'Save model');

        $post = Post::model()->findByPk($post->getPrimaryKey());

        $this->assertNotEquals('0000-00-00 00:00:00', 'First create date');
        $this->assertNotEquals('0000-00-00 00:00:00', 'First update date');

        $this->assertStringMatchesFormat('%d-%d-%d %d:%d:%d', $post->date, 'Create date format');
        $this->assertStringMatchesFormat('%d-%d-%d %d:%d:%d', $post->update_date, 'Update date format');

        $this->assertNotEquals($update_date, $post->update_date, 'New updated date');
    }

    public function testCategoryIdIsExist()
    {
        $this->post->category_id = 0;
        $this->assertFalse($this->post->validate(['category_id']), 'Empty category');

        $this->post->category_id = 1;
        $this->assertTrue($this->post->validate(['category_id']), 'Existing category');

        $this->post->category_id = 100;
        $this->assertFalse($this->post->validate(['category_id']), 'Other category');
    }

    public function testAuthorIdIsExist()
    {
        $this->post->author_id = 0;
        $this->assertTrue($this->post->validate(['author_id']), 'Empty author');

        $this->post->author_id = 1;
        $this->assertTrue($this->post->validate(['author_id']), 'Existing author');

        $this->post->author_id = 100;
        $this->assertFalse($this->post->validate(['author_id']), 'Other author');
    }

    public function testGroupIdIsExist()
    {
        $this->post->group_id = 0;
        $this->assertTrue($this->post->validate(['group_id']), 'Empty group');

        $this->post->group_id = 1;
        $this->assertTrue($this->post->validate(['group_id']), 'Existing group');

        $this->post->group_id = 100;
        $this->assertFalse($this->post->validate(['group_id']), 'Other group');
    }

    public function testBelongsToCategory()
    {
        $post = $this->blog_post('post_with_category');
        $this->assertInstanceOf(Category::class, $post->category);
    }

    public function testBelongsToAuthor()
    {
        $post = $this->blog_post('post_with_author');
        $this->assertInstanceOf(User::class, $post->author);
    }

    public function testBelongsToGroup()
    {
        $post = $this->blog_post('post_with_group');
        $this->assertInstanceOf(Group::class, $post->group);
    }

    public function testSafeAttributesOnSearchScenario()
    {
        $category = new Post('search');

        $mustBeSafe = [
            'id',
            'date',
            'category_id',
            'author_id',
            'title',
            'text',
            'public',
            'group_id',
        ];

        $safeAttrs = $category->safeAttributeNames;

        sort($mustBeSafe);
        sort($safeAttrs);

        $this->assertGreaterThanOrEqual($mustBeSafe, $safeAttrs);
    }
}