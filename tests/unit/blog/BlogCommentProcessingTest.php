<?php

Yii::import('application.modules.blog.models.*');

class BlogCommentProcessingTest extends DbTestCase
{
    public $fixtures = [
        'comment'=>'BlogPostComment',
        'blog_post'=>'BlogPost',
        'blog_category'=>'BlogCategory',
        'blog_postGroup'=>'BlogPostGroup',
        'new_gallery'=>'NewsGallery',
        'user'=>'User',
    ];

    public function testComment()
    {
        /** @var BlogPost $post */
        $post = BlogPost::model()->findByPk(1);

        $comment = new BlogPostComment();

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
