<?php

namespace tests\acceptance\register;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;

class RegisterCest
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

    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('registration');
        $I->see('Регистрация', '.portlet-title');
        $I->seeElement('#register-form');

        $I->fillField('RegistrationForm[username]', 'new-user');
        $I->fillField('RegistrationForm[email]', 'new-user@app.test');
        $I->fillField('RegistrationForm[password]', 'password');
        $I->fillField('RegistrationForm[confirm]', 'password');
        $I->fillField('RegistrationForm[lastname]', 'Last');
        $I->fillField('RegistrationForm[name]', 'First');
        $I->fillField('RegistrationForm[verifyCode]', 'test');
        $I->click('Зарегистрироваться', '#register-form');

        $I->see('Подтвердите регистрацию, проследовав по ссылке в отправленном Вам письме', '.flash-success');

        $I->seeEmailSentTo('new-user@app.test');
    }
}
