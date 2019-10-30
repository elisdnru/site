<?php

namespace tests\acceptance\blog\comment;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

class SendCest
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

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1/post-1');
        $I->seeElement('#comment-form');

        $I->fillField('CommentForm[name]', 'Name');
        $I->fillField('CommentForm[email]', 'new-comment@app.test');
        $I->fillField('CommentForm[site]', 'https://app.test');
        $I->fillField('CommentForm[text]', 'New Comment');
        $I->fillField('CommentForm[yqe1]', '1');
        $I->click('Отправить комментарий', '#comment-form');

        $I->see('Ваш коментарий добавлен', '.flash-success');
        $I->seeInSource('<p>New Comment</p>');
    }

    public function notValid(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1/post-1');
        $I->seeElement('#comment-form');

        $I->click('Отправить комментарий', '#comment-form');

        $I->see('Напишите текст комментария.', '.errorSummary');
        $I->see('Представьтесь, пожалуйста.', '.errorSummary');
        $I->see('Введите Email', '.errorSummary');
    }

    public function user(AcceptanceTester $I): void
    {
        $I->amLoggedInByUser();
        $I->amOnPage('blog/1/post-1');
        $I->seeElement('#comment-form');

        $I->fillField('CommentForm[text]', 'New Comment');
        $I->fillField('CommentForm[yqe1]', '1');
        $I->click('Отправить комментарий', '#comment-form');

        $I->see('Ваш коментарий добавлен', '.flash-success');
    }
}
