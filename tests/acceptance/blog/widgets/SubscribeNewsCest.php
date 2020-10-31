<?php

namespace tests\acceptance\blog\widgets;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

class SubscribeNewsCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'group' => GroupFixture::class,
            'user' => UserFixture::class,
            'post' => PostFixture::class,
        ]);
    }

    public function show(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/10/post-with-subscribe-news');
        $I->seeResponseCodeIs(200);
        $I->seeElement('.entry .subscribe-after-post');
    }
}
