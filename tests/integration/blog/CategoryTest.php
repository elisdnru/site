<?php

namespace tests\integration\blog;

use app\modules\blog\models\Category;
use Codeception\Test\Unit;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @method blog_post($id)
 * @method tester->grabFixture('blog_category', $id)
 * @method blog_postGroup($id)
 * @method user($id)
 */
class CategoryTest extends Unit
{
    /**
     * @var \tests\IntegrationTester
     */
    protected $tester;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        $this->tester->haveFixtures([
            'blog_post' => [
                'class' => PostFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/blog_posts.php'
            ],
            'blog_category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/blog_categories.php'
            ],
            'blog_post_group' => [
                'class' => GroupFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/blog_post_groups.php'
            ],
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/users.php'
            ]
        ]);
    }

    /**
     * @var Category
     */
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function testRequired(): void
    {
        $this->assertFalse($this->category->validate());
        $this->assertEquals([
            'alias' => ['Необходимо заполнить поле «URL транслитом».'],
            'title' => ['Необходимо заполнить поле «Наименование».'],
        ], $this->category->getErrors());
    }

    public function testParentIdExists(): void
    {
        $this->category->parent_id = 1;
        $this->assertTrue($this->category->validate(['parent_id']));

        $this->category->parent_id = 100;
        $this->assertFalse($this->category->validate(['parent_id']));
    }

    public function testParentRelation(): void
    {
        $category = $this->tester->grabFixture('blog_category', 'child_category');
        $this->assertInstanceOf(Category::class, $category->parent);
    }

    public function testPostsRelation(): void
    {
        $category = $this->tester->grabFixture('blog_category', 'category_with_posts');
        $this->assertCount(2, $category->posts);

        $category = $this->tester->grabFixture('blog_category', 'category_without_posts');
        $this->assertCount(0, $category->posts);
    }

    public function testPostsCountRelation(): void
    {
        $category = $this->tester->grabFixture('blog_category', 'category_with_posts');
        $this->assertEquals(2, $category->posts_count);

        $category = $this->tester->grabFixture('blog_category', 'category_without_posts');
        $this->assertEquals(0, $category->posts_count);
    }

    public function testChildRelation(): void
    {
        $category = $this->tester->grabFixture('blog_category', 'parent_category');
        $this->assertCount(1, $category->child_items);

        $category = $this->tester->grabFixture('blog_category', 'child_category');
        $this->assertCount(0, $category->child_items);
    }

    public function testPublicItemsCountRelation(): void
    {
        $category = $this->tester->grabFixture('blog_category', 'category_with_posts');
        $this->assertEquals(1, $category->items_count);

        $category = $this->tester->grabFixture('blog_category', 'category_without_posts');
        $this->assertEquals(0, $category->items_count);
    }
}
