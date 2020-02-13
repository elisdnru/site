<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

class FeedCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
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

        $I->seeInSource('<title>Post 1</title>');
        $I->seeInSource('<link>http://nginx:81/blog/1/post-1</link>');
        $I->dontSeeInSource('<title>Post 2</title>');
    }
}
