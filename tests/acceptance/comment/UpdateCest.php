<?php

declare(strict_types=1);

namespace tests\acceptance\comment;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

final class UpdateCest
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

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('comment/update/4');
        $I->seeResponseCodeIs(403);
    }

    public function own(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('comment/update/4');
        $I->seeResponseCodeIs(200);
        $I->seeElement('#comment-form');
        $I->see('User Comment', 'textarea');

        $I->fillField('CommentEditForm[text]', 'Updated Comment');
        $I->click('Сохранить комментарий', '#comment-form');

        $I->see('Ваш комментарий сохранён', '.flash-success');
        $I->seeInSource('<p>Updated Comment</p>');
    }

    public function notOwn(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('comment/update/3');
        $I->seeResponseCodeIs(403);
    }
}
