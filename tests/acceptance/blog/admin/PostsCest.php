<?php

declare(strict_types=1);

namespace tests\acceptance\blog\admin;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class PostsCest
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

    public function access(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('blog/admin/post');
        $I->seeResponseCodeIs(403);
    }

    public function index(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/post');
        $I->seeResponseCodeIs(200);
        $I->see('Записи блога', 'h1');
    }

    public function create(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/post/create');
        $I->seeResponseCodeIs(200);
        $I->see('Добавление записи', 'h1');
    }

    public function update(AcceptanceTester $I): void
    {
        $I->amLoggedInByAdmin();
        $I->amOnPage('blog/admin/post/7/update');
        $I->seeResponseCodeIs(200);
        $I->see('Редактирование записи', 'h1');

        $I->seeElement('#post-form');

        $I->fillField('PostForm[text]', 'New Text');
        $I->click('Сохранить', '#post-form');

        $I->seeInSource('<p>New Text</p>');
    }
}
