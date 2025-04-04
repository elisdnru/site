<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class LoginCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);
    }

    public function guestUlogin(AcceptanceTester $I): void
    {
        $I->dontHaveFeature('OAUTH');
        $I->amOnPage('login');
        $I->see('Вход в аккаунт', 'h1');
        $I->seeElement('#login-form');
        $I->seeElement('#uLogin');
        $I->dontSeeElement('.auth');
    }

    public function guestOauth(AcceptanceTester $I): void
    {
        $I->haveFeature('OAUTH');
        $I->amOnPage('login');
        $I->see('Вход в аккаунт', 'h1');
        $I->seeElement('#login-form');
        $I->dontSeeElement('#uLogin');
        $I->seeElement('.auth');
    }

    public function user(AcceptanceTester $I): void
    {
        $I->amOnPage('login');
        $I->see('Вход в аккаунт', 'h1');
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'user');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');

        $I->see('Новое в Блоге');
        $I->seeLink('Профиль', '/profile');
        $I->seeCookie('_identity');
        $I->dontSeeElement('.admin-bar');
    }

    public function admin(AcceptanceTester $I): void
    {
        $I->amOnPage('login');
        $I->see('Вход в аккаунт', 'h1');
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');

        $I->see('Новое в Блоге');
        $I->seeCookie('_identity');
        $I->seeElement('.admin-bar');
    }

    public function unconfirmed(AcceptanceTester $I): void
    {
        $I->amOnPage('login');
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'confirm');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');

        $I->see('Некорректное имя пользователя или пароль.');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('login');
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'wrong');
        $I->click('Вход в учётную запись', '#login-form');

        $I->see('Некорректное имя пользователя или пароль.');
    }
}
