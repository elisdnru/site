<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class ShowCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'group' => GroupFixture::class,
            'user' => UserFixture::class,
            'post' => PostFixture::class,
            'comment' => CommentFixture::class,
        ]);
    }

    public function published(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1/post-1');
        $I->seeResponseCodeIs(200);
        $I->see('Post 1', 'h1');
        $I->see('Title 1', 'title');
        $I->seeInSource('<p>Post Content</p>');
        $I->seeLink('Философия CI, CD и CD', 'https://deworker.pro/edu/series/interactive-site/ci-cd-philosophy');
    }

    public function draft(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/2/post');
        $I->seeResponseCodeIs(404);
    }

    public function redirect(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1?from=fb');
        $I->seeResponseCodeIs(200);
        $I->seeInCurrentUrl('blog/1/post-1?from=fb');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/0/post');
        $I->seeResponseCodeIs(404);
    }

    public function comments(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/6/post-comments');
        $I->seeResponseCodeIs(200);
        $I->see('Post With Comments', 'h1');
        $I->seeInSource('<p>Public Comment</p>');
        $I->dontSeeInSource('<p>Draft Comment</p>');
        $I->seeInSource(
            <<<'END'
                <p>Lorem ipsum dolor sit amet.</p>

                <p>XSS</p>

                <pre>
                &lt;p&gt;Code&lt;/p&gt;
                &lt;script&gt;alert(&#039;XSS&#039;);&lt;/script&gt;
                </pre>

                <p>&lt;script&gt;alert('XSS');&lt;/script&gt;</p>
                END
        );
    }

    public function markdown(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/15/post-markdown');
        $I->seeResponseCodeIs(200);
        $I->see('Post With Markdown', 'h1');
        $I->seeInSource(
            <<<'END'
                <p>Lorem ipsum <code>dolor</code> sit amet.</p>

                <div class="hl-code"><div class="php-hl-main"><pre><span class="php-hl-reserved">interface</span> <span class="php-hl-identifier">A</span> <span class="php-hl-reserved">extends</span> <span class="php-hl-identifier">B</span>
                <span class="php-hl-brackets">{</span>
                    <span class="php-hl-reserved">public</span> <span class="php-hl-reserved">function</span> <span class="php-hl-identifier">process</span><span class="php-hl-brackets">(</span><span class="php-hl-var">$var</span><span class="php-hl-brackets">)</span><span class="php-hl-code">: </span><span class="php-hl-identifier">void</span>
                <span class="php-hl-brackets">}</span></pre></div></div>
                END
        );
    }
}
