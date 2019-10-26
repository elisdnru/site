<?php

namespace tests;

use CDbTestCase;

class DbTestCase extends CDbTestCase
{
    private static $loadFixturesFlag = false;

    protected $normalAliases = [
        'normal-alias',
        'normal_alias',
        'normalAlias_2',
        '3_normalAlias',
    ];

    protected $failAliases = [
        ' crazy_alias',
        'crazy_alias ',
        'crazy.alias',
        'crazy/alias',
        'crazy alias',
    ];

    /**
     * Load fixtures one time
     */
    protected function setUp()
    {
        if (!self::$loadFixturesFlag && is_array($this->fixtures)) {
            $this->loadFixtures();
            self::$loadFixturesFlag = true;
        }
    }

    /**
     * Load fixtures
     * @param null $fixtures
     */
    public function loadFixtures($fixtures = null)
    {
        if ($fixtures === null) {
            $fixtures = $this->fixtures;
        }

        $this->getFixtureManager()->load($fixtures);
    }

    public function testDummy()
    {
    }
}
