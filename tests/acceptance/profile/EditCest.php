<?php

namespace tests\acceptance\profile;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class EditCest
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

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('profile/edit');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function info(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');
        $I->see('Редактировать профиль', '.portlet-title');

        $I->seeElement('#profile-form');

        $I->fillField('User[lastname]', 'Bond');
        $I->fillField('User[name]', 'James');
        $I->fillField('User[middlename]', 'Ms');
        $I->fillField('User[site]', 'http://app.test');
        $I->attachFile('User[avatar]', 'files/avatar.png');

        $I->click('Сохранить', '#profile-form');

        $I->see('Профиль сохранён.', '.flash-success');

        $I->see('Bond James Ms', 'h3');
        $I->seeLink('http://app.test', 'http://app.test');
        $I->seeInSource('<img src="/upload/images/users/avatars/');
    }

    public function infoValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');

        $I->seeElement('#profile-form');

        $I->fillField('User[lastname]', '');
        $I->fillField('User[name]', '');
        $I->fillField('User[site]', 'asd');

        $I->click('Сохранить', '#profile-form');

        $I->see('Необходимо заполнить поле «Фамилия».', '.errorMessage');
        $I->see('Необходимо заполнить поле «Имя».', '.errorMessage');
        $I->see('Сайт не является правильным URL.', '.errorMessage');
    }

    public function password(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');
        $I->see('Редактировать профиль', '.portlet-title');

        $I->seeElement('#profile-form');

        $I->fillField('User[old_password]', 'password');
        $I->fillField('User[new_password]', 'new-password');
        $I->fillField('User[new_confirm]', 'new-password');

        $I->click('Сохранить', '#profile-form');

        $I->see('Профиль сохранён.', '.flash-success');
    }

    public function passwordConfirmValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');

        $I->seeElement('#profile-form');

        $I->fillField('User[old_password]', '');
        $I->fillField('User[new_password]', 'new-password');
        $I->fillField('User[new_confirm]', 'wrong');

        $I->click('Сохранить', '#profile-form');

        $I->see('Пароли не совпадают.', '.errorMessage');
    }

    public function passwordEmptyValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');

        $I->seeElement('#profile-form');

        $I->fillField('User[old_password]', '');
        $I->fillField('User[new_password]', 'new-password');
        $I->fillField('User[new_confirm]', 'new-password');

        $I->click('Сохранить', '#profile-form');

        $I->see('Введите текущий пароль.', '.errorMessage');
    }

    public function passwordWrongValidation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');

        $I->seeElement('#profile-form');

        $I->fillField('User[old_password]', 'wrong');
        $I->fillField('User[new_password]', 'new-password');
        $I->fillField('User[new_confirm]', 'new-password');

        $I->click('Сохранить', '#profile-form');

        $I->see('Неверный текущий пароль.', '.errorMessage');
    }
}
