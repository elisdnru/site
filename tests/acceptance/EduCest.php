<?php

declare(strict_types=1);

namespace tests\acceptance;

use tests\AcceptanceTester;

/**
 * @psalm-api
 */
final class EduCest
{
    public function index(AcceptanceTester $I): void
    {
        $I->amOnPage('edu');
        $I->seeResponseCodeIs(200);
        $I->see('База знаний', 'h1');
        $I->see('База знаний', 'title');
        $I->seeLink('Что есть React: Пишем свой UI-фреймворк', 'https://deworker.pro/edu/series/what-is-react');
        $I->seeLink('Суть компонентного фреймворка', 'https://deworker.pro/edu/series/http-framework/definition');
    }
}
