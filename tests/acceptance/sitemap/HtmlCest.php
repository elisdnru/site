<?php

declare(strict_types=1);

namespace tests\acceptance\sitemap;

use tests\AcceptanceTester;

/**
 * @psalm-api
 */
final class HtmlCest
{
    public function success(AcceptanceTester $I): void
    {
        $I->amOnPage('sitemap');
        $I->seeResponseCodeIs(200);
        $I->see('Карта сайта', 'h1');
        $I->see('Карта сайта', 'title');

        $I->seeLink('Авторские продукты', '/products');
        $I->seeLink('Официальный блог', '/blog');
        $I->seeLink('Контактные данные', '/contacts');
        $I->seeLink('Неделя ООП', '/oop-week');
        $I->seeLink('Git и Composer для начинающих', '/git-composer');
        $I->seeLink('Мастер-класс Yii2 Shop', '/yii2-shop');
        $I->seeLink('Мастер-класс Laravel', '/laravel-board');
        $I->seeLink('Мастер-класс Symfony', '/project-manager');
    }
}
