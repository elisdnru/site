<?php

declare(strict_types=1);

namespace tests\integration\blog;

use app\modules\blog\models\Comment;
use app\modules\blog\models\Post;
use Codeception\Test\Unit;
use LogicException;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;
use tests\IntegrationTester;

/**
 * @internal
 */
final class CommentProcessingTest extends Unit
{
    /**
     * @var IntegrationTester
     */
    protected $tester;

    public function testComment(): void
    {
        $post = Post::findOne(1) ?: throw new LogicException('Not found.');
        $comment = new Comment();

        $comment->material_id = $post->id;
        $comment->public = 1;
        $comment->moder = 0;
        $comment->user_id = 1;
        $comment->name = 'Name';
        $comment->email = 'user@example.com';
        $comment->site = 'http://example.com';
        $comment->text = <<<'END'
            Lorem ipsum dolor sit amet.

            <p onclick="script()">XSS</p>

            <pre>
            <p>Code</p>
            <script>alert('XSS');</script>
            </pre>

            <script>alert('XSS');</script>
            END;

        $expected = <<<'END'
            <p>Lorem ipsum dolor sit amet.</p>

            <p>XSS</p>

            <pre>
            &lt;p&gt;Code&lt;/p&gt;
            &lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;
            </pre>

            <p>&lt;script&gt;alert('XSS');&lt;/script&gt;</p>
            END;
        self::assertTrue($comment->save(), 'Save model');
        self::assertEquals($expected, $comment->text_purified);
    }

    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    protected function _before(): void
    {
        $this->tester->haveFixtures([
            'comment' => CommentFixture::class,
            'blog_post' => PostFixture::class,
            'blog_category' => CategoryFixture::class,
            'blog_post_group' => GroupFixture::class,
            'user' => UserFixture::class,
        ]);
    }
}
