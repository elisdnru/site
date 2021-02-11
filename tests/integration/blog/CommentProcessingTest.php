<?php

namespace tests\integration\blog;

use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use Codeception\Test\Unit;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\user\UserFixture;
use tests\IntegrationTester;

class CommentProcessingTest extends Unit
{
    /**
     * @var IntegrationTester
     */
    protected $tester;

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before()
    {
        $this->tester->haveFixtures([
            'comment' => CommentFixture::class,
            'blog_post' => PostFixture::class,
            'blog_category' => CategoryFixture::class,
            'blog_post_group' => GroupFixture::class,
            'user' => UserFixture::class,
        ]);
    }

    public function testComment(): void
    {
        $post = Post::findOne(1);

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
