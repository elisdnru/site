<?php

use app\modules\blog\models\Category;
use app\modules\blog\models\Post;
use app\modules\blog\models\Comment;
use app\modules\blog\models\Group;
use app\modules\user\models\User;

class CommentProcessingTest extends DbTestCase
{
    public $fixtures = [
        'comment'=> Comment::class,
        'blog_post'=> Post::class,
        'blog_category'=> Category::class,
        'blog_postGroup'=> Group::class,
        'user'=> User::class,
    ];

    public function testComment()
    {
        /** @var Post $post */
        $post = Post::model()->findByPk(1);

        $comment = new Comment();

        $comment->parent_id = 0;
        $comment->material_id = 1;
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
