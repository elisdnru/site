<?php

namespace tests\integration\blog;

use app\modules\blog\models\Post;
use Codeception\Test\Unit;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;
use tests\IntegrationTester;

class PostProcessingTest extends Unit
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
            'blog_post' => PostFixture::class,
            'blog_category' => CategoryFixture::class,
            'blog_post_group' => GroupFixture::class,
            'user' => UserFixture::class,
        ]);
    }

    public function testShort(): void
    {
        /** @var Post $post */
        $post = Post::findOne(1);

        $post->short = 'Lorem ipsum dolor sit amet.';
        self::assertTrue($post->save(), 'Save model');
        self::assertEquals('Lorem ipsum dolor sit amet.', $post->short_purified);
    }

    public function testText(): void
    {
        /** @var Post $post */
        $post = Post::findOne(1);

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
        self::assertTrue($post->save(), 'Save model');
        self::assertEquals($expected, $post->text_purified);
    }
}
