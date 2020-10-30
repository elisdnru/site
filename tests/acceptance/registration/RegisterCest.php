<?php

namespace tests\acceptance\registration;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class RegisterCest
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

        $I->amOnPage('registration');
        $I->see('Регистрация', '.portlet-title');
        $I->seeElement('#register-form');

        $I->fillField('RegistrationForm[username]', 'new-user');
        $I->fillField('RegistrationForm[email]', 'new-user@app.test');
        $I->fillField('RegistrationForm[password]', 'password');
        $I->fillField('RegistrationForm[confirm]', 'password');
        $I->fillField('RegistrationForm[lastname]', 'Last');
        $I->fillField('RegistrationForm[firstname]', 'First');
        $I->fillField('RegistrationForm[test1]', '42');
        $I->fillField('RegistrationForm[test2]', '42');
        $I->click('Зарегистрироваться', '#register-form');

        $I->see('Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме', '.flash-success');

        $I->seeEmailSentTo('new-user@app.test');
    }

    public function empty(AcceptanceTester $I): void
    {
        $I->amOnPage('registration');
        $I->see('Регистрация', '.portlet-title');
        $I->seeElement('#register-form');

        $I->click('Зарегистрироваться', '#register-form');

        $I->see('Необходимо заполнить «Логин».', '.errorMessage');
        $I->see('Необходимо заполнить «Email».', '.errorMessage');
        $I->see('Необходимо заполнить «Новый пароль».', '.errorMessage');
        $I->see('Необходимо заполнить «Имя».', '.errorMessage');
        $I->see('Необходимо заполнить «Фамилия».', '.errorMessage');
        $I->see('Необходимо заполнить «Код 1».', '.errorMessage');
        $I->see('Необходимо заполнить «Код 2».', '.errorMessage');
    }

    public function notValid(AcceptanceTester $I): void
    {
        $I->amOnPage('registration');
        $I->see('Регистрация', '.portlet-title');
        $I->seeElement('#register-form');

        $I->fillField('RegistrationForm[username]', 'new@user');
        $I->fillField('RegistrationForm[email]', 'new-user');
        $I->fillField('RegistrationForm[password]', 'pass');
        $I->fillField('RegistrationForm[confirm]', 'wrong');
        $I->fillField('RegistrationForm[test1]', '11');
        $I->fillField('RegistrationForm[test2]', '11');

        $I->click('Зарегистрироваться', '#register-form');

        $I->see('Логин содержит запрещённые символы.', '.errorMessage');
        $I->see('Значение «Email» не является правильным email адресом.', '.errorMessage');
        $I->see('Пароль должен быть не короче 6 символов.', '.errorMessage');
        $I->see('Пароли не совпадают.', '.errorMessage');
        $I->see('Неправильный проверочный код.', '.errorMessage');
    }

    public function captcha1(AcceptanceTester $I): void
    {
        $I->amOnPage('registration/captcha1');
        $I->seeResponseCodeIs(200);
        $I->seeInSource('PNG');
    }

    public function captcha2(AcceptanceTester $I): void
    {
        $I->amOnPage('registration/captcha2');
        $I->seeResponseCodeIs(200);
        $I->seeInSource('PNG');
    }

    public function captchaRefresh(AcceptanceTester $I): void
    {
        $I->amOnPage('registration/captcha1?refresh=1&_=1582205362403');
        $I->seeResponseCodeIs(200);
        $I->seeInSource('"url":');
    }
}
