<?php

declare(strict_types=1);

namespace tests\acceptance\profile;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class PasswordCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);
    }

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('profile/password');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/password');
        $I->see('Смена пароля', '.portlet-title');

        $I->seeElement('#password-form');

        $I->fillField('PasswordForm[current]', 'password');
        $I->fillField('PasswordForm[password]', 'new-password');
        $I->fillField('PasswordForm[confirm]', 'new-password');

        $I->click('Сохранить', '#password-form');

        $I->see('Пароль сохранён.', '.flash-success');
    }

    public function emptyValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/password');

        $I->seeElement('#password-form');

        $I->fillField('PasswordForm[current]', '');
        $I->fillField('PasswordForm[password]', '');
        $I->fillField('PasswordForm[confirm]', '');

        $I->click('Сохранить', '#password-form');

        $I->see('Необходимо заполнить «Текущий пароль».', '.error-message');
        $I->see('Необходимо заполнить «Новый пароль».', '.error-message');
    }

    public function confirmValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/password');

        $I->seeElement('#password-form');

        $I->fillField('PasswordForm[current]', '');
        $I->fillField('PasswordForm[password]', 'new-password');
        $I->fillField('PasswordForm[confirm]', 'wrong');

        $I->click('Сохранить', '#password-form');

        $I->see('Пароли не совпадают.', '.error-message');
    }

    public function wrongValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/password');

        $I->seeElement('#password-form');

        $I->fillField('PasswordForm[current]', 'wrong');
        $I->fillField('PasswordForm[password]', 'new-password');
        $I->fillField('PasswordForm[confirm]', 'new-password');

        $I->click('Сохранить', '#password-form');

        $I->see('Неверный текущий пароль.', '.error-message');
    }
}
