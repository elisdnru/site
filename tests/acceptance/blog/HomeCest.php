<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

final class HomeCest
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

    public function home(AcceptanceTester $I): void
    {
        $I->amOnPage('blog');
        $I->seeResponseCodeIs(200);
        $I->see('Блог', 'h1');
        $I->seeLink('Post 1', '/blog/1/post-1');
        $I->dontSeeLink('Post 2');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/page-2');
        $I->seeResponseCodeIs(200);
        $I->see('Блог', 'h1');
        $I->see('Блог - Страница 2', 'title');
    }
}
