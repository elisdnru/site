<?php

namespace tests\acceptance;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class RemindCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);
    }

    public function success(AcceptanceTester $I): void
    {
        $I->dontHaveEmails();

        $I->amOnPage('remind');
        $I->see('Восстановление пароля', '.portlet-title');
        $I->seeElement('#remind-form');

        $I->fillField('RemindForm[email]', 'remind@app.test');
        $I->click('Восстановить пароль', '#remind-form');

        $I->see('Новые параметры отправлены на Email', '.flash-success');

        $I->seeEmailSentTo('remind@app.test');

        $I->amOnPage('login');
        $I->seeElement('#login-form');

        $I->fillField('LoginForm[username]', 'remind');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');

        $I->see('Некорректное имя пользователя или пароль.');
    }

    public function wrong(AcceptanceTester $I): void
    {
        $I->amOnPage('remind');
        $I->seeElement('#remind-form');

        $I->fillField('RemindForm[email]', 'wrong@app.test');
        $I->click('Восстановить пароль', '#remind-form');

        $I->see('Пользователь не найден', '.flash-error');
    }
}
