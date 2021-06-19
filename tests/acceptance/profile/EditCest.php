<?php

declare(strict_types=1);

namespace tests\acceptance\profile;

use tests\AcceptanceTester;
use tests\fixtures\user\UserFixture;
use yii\helpers\FileHelper;

class EditCest
{
    // phpcs:disable
    // PSR2.Method Declarations.Underscore
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'user' => UserFixture::class,
        ]);

        $dir = __DIR__ . '/../../../public/upload/images/users/avatars';
        FileHelper::createDirectory($dir, 0777);
        $target = $dir . '/160b82352f2c6025f74398703828a2ff.png';
        copy(__DIR__ . '/../../_data/files/avatar.png', $target);
        chmod($target, 0666);
    }

    public function guest(AcceptanceTester $I): void
    {
        $I->amOnPage('profile/edit');
        $I->see('Вход в аккаунт', 'h1');
    }

    public function success(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');
        $I->see('Редактировать профиль', '.portlet-title');

        $I->seeElement('#profile-form');

        $I->fillField('ProfileForm[lastname]', 'Bond');
        $I->fillField('ProfileForm[firstname]', 'James');
        $I->fillField('ProfileForm[site]', 'http://app.test');
        $I->attachFile('ProfileForm[avatar]', 'files/avatar.png');

        $I->click('Сохранить', '#profile-form');

        $I->see('Профиль сохранён.', '.flash-success');

        $I->see('Bond James', 'h3');
        $I->seeLink('http://app.test', 'http://app.test');
        $I->seeInSource('<img src="/upload/images/users/avatars/');
    }

    public function delAvatar(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(6);
        $I->amOnPage('profile/edit');
        $I->see('Редактировать профиль', '.portlet-title');
        $I->seeInSource('<img src="/upload/images/users/avatars/');

        $I->seeElement('#profile-form');

        $I->fillField('ProfileForm[del_avatar]', '1');

        $I->click('Сохранить', '#profile-form');

        $I->see('Профиль сохранён.', '.flash-success');

        $I->see('Avatar User', 'h3');
        $I->dontSeeInSource('<img src="/upload/images/users/avatars/');
    }

    public function validation(AcceptanceTester $I): void
    {
        $I->amLoggedInBy(5);
        $I->amOnPage('profile/edit');

        $I->seeElement('#profile-form');

        $I->fillField('ProfileForm[lastname]', '');
        $I->fillField('ProfileForm[firstname]', '');
        $I->fillField('ProfileForm[site]', 'asd');
        $I->attachFile('ProfileForm[avatar]', 'files/no-avatar.txt');

        $I->click('Сохранить', '#profile-form');

        $I->see('Необходимо заполнить «Фамилия».', '.error-message');
        $I->see('Необходимо заполнить «Имя».', '.error-message');
        $I->see('Значение «Сайт» не является правильным URL.', '.error-message');
        $I->see('Файл «no-avatar.txt» не является изображением.', '.error-message');
    }
}
