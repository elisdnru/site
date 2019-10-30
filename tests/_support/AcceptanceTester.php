<?php

namespace tests;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function amLoggedInByAdmin(): void
    {
        $I = $this;

        $I->amOnPage('login');
        $I->fillField('LoginForm[username]', 'admin');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');
        $I->see('Новое в Блоге');
    }

    public function amLoggedInByUser(): void
    {
        $I = $this;

        $I->amOnPage('login');
        $I->fillField('LoginForm[username]', 'user');
        $I->fillField('LoginForm[password]', 'password');
        $I->click('Вход в учётную запись', '#login-form');
        $I->see('Новое в Блоге');
    }
}
