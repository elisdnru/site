<?php

namespace tests;

use CDbTestCase;

class DbTestCase extends CDbTestCase
{
    private static $loadFixturesFlag = false;

    protected function setUp(): void
    {
        if (!self::$loadFixturesFlag && is_array($this->fixtures)) {
            $this->loadFixtures();
            self::$loadFixturesFlag = true;
        }
    }

    public function loadFixtures(array $fixtures = null): void
    {
        if ($fixtures === null) {
            $fixtures = $this->fixtures;
        }

        $this->getFixtureManager()->load($fixtures);
    }
}
