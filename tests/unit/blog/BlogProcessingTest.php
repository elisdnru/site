<?php

Yii::import('application.modules.blog.models.*');

class BlogProcessingTest extends DbTestCase
{
    public $fixtures = [
        'blog_post'=>'BlogPost',
        'blog_category'=>'BlogCategory',
        'blog_postGroup'=>'BlogPostGroup',
        'new_gallery'=>'NewsGallery',
        'user'=>'User',
    ];

    public function testShort()
    {
        /** @var BlogPost $post */
        $post = BlogPost::model()->findByPk(1);

        $post->short = 'Lorem ipsum dolor sit amet.';
        $this->assertTrue($post->save(), 'Save model');
        $this->assertEquals('Lorem ipsum dolor sit amet.', $post->short_purified);
    }

    public function testText()
    {
        /** @var BlogPost $post */
        $post = BlogPost::model()->findByPk(1);

        $source = <<<END
Lorem ipsum dolor sit amet.

~~~
[php]
interface A extends B
{
    public function process(\$var): void
}
~~~
END;

        $expected = <<<END
<p>Lorem ipsum dolor sit amet.</p>

<div class="hl-code"><div class="php-hl-main"><pre><span class="php-hl-reserved">interface</span> <span class="php-hl-identifier">A</span> <span class="php-hl-reserved">extends</span> <span class="php-hl-identifier">B</span>
<span class="php-hl-brackets">{</span>
    <span class="php-hl-reserved">public</span> <span class="php-hl-reserved">function</span> <span class="php-hl-identifier">process</span><span class="php-hl-brackets">(</span><span class="php-hl-var">\$var</span><span class="php-hl-brackets">)</span><span class="php-hl-code">: </span><span class="php-hl-identifier">void</span>
<span class="php-hl-brackets">}</span></pre></div></div>

END;

        $post->text = $source;
        $this->assertTrue($post->save(), 'Save model');
        $this->assertEquals($expected, $post->text_purified);
    }
}
