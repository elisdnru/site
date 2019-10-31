<?php

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class LoginCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'fixtures/users.php'
            ]
        ]);
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
        $I->dontSeeElement('.adminbar');
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
        $I->seeElement('.adminbar');
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
