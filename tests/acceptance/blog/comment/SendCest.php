<?php

declare(strict_types=1);

namespace tests\acceptance\blog\comment;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\CommentFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

final class SendCest
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
        $I->amOnPage('blog/6/post-comments');
        $I->seeElement('#comment-form');

        $I->fillField('CommentForm[parent_id]', '4');
        $I->fillField('CommentForm[name]', 'Name');
        $I->fillField('CommentForm[email]', 'new-comment@app.test');
        $I->fillField('CommentForm[site]', 'https://app.test');
        $I->fillField('CommentForm[text]', 'New Comment');
        $I->fillField('CommentForm[yqe1]', '1');
        $I->click('Отправить комментарий', '#comment-form');

        $I->see('Ваш коментарий добавлен', '.flash-success');
        $I->seeInSource('<p>New Comment</p>');
        $I->seeEmailSentTo('author@app.test');
    }

    public function notValid(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/1/post-1');
        $I->seeElement('#comment-form');

        $I->click('Отправить комментарий', '#comment-form');

        $I->see('Напишите текст комментария.', '.error-message');
        $I->see('Представьтесь, пожалуйста.', '.error-message');
        $I->see('Введите Email', '.error-message');
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
