<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

class ShowCest
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

    public function published(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1/post-1');
        $I->seeResponseCodeIs(200);
        $I->see('Post 1', 'h1');
        $I->see('Title 1', 'title');
        $I->seeInSource('<p>Post Content</p>');
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
}