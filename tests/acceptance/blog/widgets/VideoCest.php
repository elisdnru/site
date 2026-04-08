<?php

declare(strict_types=1);

namespace acceptance\blog\widgets;

use tests\AcceptanceTester;
use tests\fixtures\blog\CategoryFixture;
use tests\fixtures\blog\GroupFixture;
use tests\fixtures\blog\PostFixture;
use tests\fixtures\user\UserFixture;

/**
 * @psalm-api
 */
final class VideoCest
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
        $I->amOnPage('blog/16/post-with-vk-video');
        $I->seeResponseCodeIs(200);
        $I->seeElement('iframe[src="https://vkvideo.ru/video_ext.php?oid=-205214227&id=456239392&hash=543dba95c5105690&hd=4"]');
    }
}
