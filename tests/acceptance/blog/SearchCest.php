<?php

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture as BlogCategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

class SearchCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'blog_groups' => GroupFixture::class,
            'blog_categories' => BlogCategoryFixture::class,
            'blog_posts' => PostFixture::class,
            'users' => UserFixture::class,
        ]);
    }

    public function post(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/search');
        $I->seeElement('.main .search-form');

        $I->fillField('.main .search-form input', 'post');
        $I->click('', '.main .search-form');

        $I->see('Поиск в блоге', 'h1');
        $I->seeInSource('<a href="/blog/1/post-1"><mark>post</mark> 1</a>');
    }
}