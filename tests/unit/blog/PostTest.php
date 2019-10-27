<?php

namespace tests\unit\blog;

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\modules\blog\models\Group;
use app\modules\user\models\User;
use tests\DbTestCase;

/**
 * @method blog_post($id)
 */
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = new Post();
    }

    public function testTitleIsRequired(): void
    {
        $this->assertFalse($this->post->validate());
        $this->assertEquals([
            'alias' => ['Необходимо заполнить поле «URL транслитом».'],
            'title' => ['Необходимо заполнить поле «Заголовок».'],
            'category_id' => ['Необходимо заполнить поле «Раздел».'],
        ], $this->post->getErrors());
    }

    public function testCreateAndUpdateDate(): void
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

    public function testCategoryIdExists(): void
    {
        $this->post->category_id = 0;
        $this->assertFalse($this->post->validate(['category_id']), 'Empty category');

        $this->post->category_id = 1;
        $this->assertTrue($this->post->validate(['category_id']), 'Existing category');

        $this->post->category_id = 100;
        $this->assertFalse($this->post->validate(['category_id']), 'Other category');
    }

    public function testAuthorIdExists(): void
    {
        $this->post->author_id = 0;
        $this->assertTrue($this->post->validate(['author_id']), 'Empty author');

        $this->post->author_id = 1;
        $this->assertTrue($this->post->validate(['author_id']), 'Existing author');

        $this->post->author_id = 100;
        $this->assertFalse($this->post->validate(['author_id']), 'Other author');
    }

    public function testGroupIdExists(): void
    {
        $this->post->group_id = 0;
        $this->assertTrue($this->post->validate(['group_id']), 'Empty group');

        $this->post->group_id = 1;
        $this->assertTrue($this->post->validate(['group_id']), 'Existing group');

        $this->post->group_id = 100;
        $this->assertFalse($this->post->validate(['group_id']), 'Other group');
    }

    public function testBelongsToCategory(): void
    {
        $post = $this->blog_post('post_with_category');
        $this->assertInstanceOf(Category::class, $post->category);
    }

    public function testBelongsToAuthor(): void
    {
        $post = $this->blog_post('post_with_author');
        $this->assertInstanceOf(User::class, $post->author);
    }

    public function testBelongsToGroup(): void
    {
        $post = $this->blog_post('post_with_group');
        $this->assertInstanceOf(Group::class, $post->group);
    }
}
