<?php

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture as BlogCategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\landing\LandingFixture;
use tests\fixtures\page\PageFixture;
use tests\fixtures\portfolio\CategoryFixture as PortfolioCategoryFixture;
use tests\fixtures\portfolio\WorkFixture;
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
            'portfolio_categories' => PortfolioCategoryFixture::class,
            'portfolio_works' => WorkFixture::class,
            'pages' => PageFixture::class,
            'landings' => LandingFixture::class,
            'users' => UserFixture::class,
        ]);
    }

    public function post(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search-form');

        $I->fillField('q', 'post');
        $I->click('', '.search-form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<a href="/blog/1/post-1"><mark>post</mark> 1</a>');
    }

    public function work(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search-form');

        $I->fillField('q', 'work');
        $I->click('', '.search-form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<a href="/portfolio/category-2/1/work-1"><mark>work</mark> 1</a>');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search-form');

        $I->fillField('q', 'about');
        $I->click('', '.search-form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<a href="/info/about"><mark>about</mark></a>');
    }

    public function landing(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search-form');

        $I->fillField('q', 'course');
        $I->click('', '.search-form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<a href="/course"><mark>course</mark></a>');
    }
}
