<?php

declare(strict_types=1);

namespace tests\acceptance\blog\widgets;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class YouTubeCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->haveFixtures([
            'category' => CategoryFixture::class,
            'group' => GroupFixture::class,
            'user' => UserFixture::class,
            'post' => PostFixture::class,
        ]);
    }

    public function show(AcceptanceTester $I): void
    {
        $I->amOnPage('blog/14/post-with-youtube');
        $I->seeResponseCodeIs(200);
        $I->seeElement('iframe[src="https://www.youtube.com/embed/000001"]');
    }
}
