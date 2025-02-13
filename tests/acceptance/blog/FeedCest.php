<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class FeedCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
            'category' => CategoryFixture::class,
            'group' => GroupFixture::class,
            'post' => PostFixture::class,
        ]);
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/feed');
        $I->seeResponseCodeIs(200);
        $I->seeElement('rss');

        $I->seeInSource('<title>Дмитрий Елисеев</title>');
        $I->seeInSource('<description>ElisDN</description>');
        $I->seeInSource('<copyright>Copyright ' . date('Y') . ' http://localhost</copyright>');

        $I->seeInSource('<title>Post 1</title>');
        $I->seeInSource('<link>http://localhost/blog/1/post-1</link>');
        $I->seeInSource('<link>http://localhost/blog/1/post-1</link>');
        $I->dontSeeInSource('<title>Post 2</title>');
    }
}
