<?php

class DbTestCase extends CDbTestCase
{
    private static $_loadFixturesFlag = false;

    protected $normalAliases = array(
        'normal-alias',
        'normal_alias',
        'normalAlias_2',
        '3_normalAlias',
    );

    protected $failAliases = array(
        ' crazy_alias',
        'crazy_alias ',
        'crazy.alias',
        'crazy/alias',
        'crazy alias',
    );

    /**
     * Load fixtures one time
     */
    protected function setUp()
    {
        if (!self::$_loadFixturesFlag && is_array($this->fixtures)) {
            $this->loadFixtures();
            self::$_loadFixturesFlag = true;
        }
    }

    /**
     * Load fixtures
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