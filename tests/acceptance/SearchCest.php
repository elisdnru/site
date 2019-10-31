<?php

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture as BlogCategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
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
            'users' => UserFixture::class,
        ]);
    }

    public function post(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search_form');

        $I->fillField('q', 'post');
        $I->click('', '.search_form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<mark>post</mark> 1');
    }

    public function work(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search_form');

        $I->fillField('q', 'work');
        $I->click('', '.search_form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<mark>work</mark> 1');
    }

    public function page(AcceptanceTester $I): void
    {
        $I->amOnPage('');
        $I->seeElement('.search_form');

        $I->fillField('q', 'about');
        $I->click('', '.search_form');

        $I->see('Поиск по сайту', 'h1');
        $I->seeInSource('<mark>about</mark>');
    }
}
