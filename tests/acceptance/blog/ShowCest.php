<?php

declare(strict_types=1);

namespace tests\acceptance\blog;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

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
    }
}
