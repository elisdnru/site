<?php

namespace tests\integration\blog;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use Codeception\Test\Unit;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\comment\CommentFixture;
use tests\fixtures\user\UserFixture;

class CommentProcessingTest extends Unit
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
            'comment' => [
                'class' => CommentFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/comments.php'
            ],
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

    public function testComment(): void
    {
        $post = Post::model()->findByPk(1);

        $comment = new Comment();

        $comment->material_id = $post->id;
        $comment->public = 1;
        $comment->moder = 0;
        $comment->user_id = 1;
        $comment->name = 'Name';
        $comment->email = 'user@example.com';
        $comment->site = 'http://example.com';
        $comment->text = <<<END
Lorem ipsum dolor sit amet.

<script>alert('XSS');</script>
END;

        $expected = <<<END
<p>Lorem ipsum dolor sit amet.</p>

<p>&lt;script&gt;alert('XSS');&lt;/script&gt;</p>
END;
        $this->assertTrue($comment->save(), 'Save model');
        $this->assertEquals($expected, $comment->text_purified);
    }
}
