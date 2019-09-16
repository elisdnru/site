<?php

namespace app\extensions\migrate;

use CDbMigration;
use CException;

/**
 * EDbMigration
 *
 * @link http://www.yiiframework.com/extension/extended-database-migration/
 * @link http://www.yiiframework.com/doc/guide/1.1/en/database.migration
 * @author Carsten Brandt <mail@cebe.cc>
 * @version 0.8.0-dev
 */
class EDbMigration extends CDbMigration
{
    /**
     * @var EMigrateCommand
     */
    private $migrateCommand;
    protected $interactive = true;

    /**
     * @param EMigrateCommand $migrateCommand
     */
    public function setCommand($migrateCommand)
    {
        $this->migrateCommand = $migrateCommand;
        $this->interactive = $migrateCommand->interactive;
    }

    /**
     * @param string $message
     * @return bool
     * @see CConsoleCommand::confirm()
     */
    public function confirm($message)
    {
        if (!$this->interactive) {
            return true;
        }
        return $this->migrateCommand->confirm($message);
    }

    /**
     * @param string $message
     * @param mixed $defaultValue will be returned when interactive is false
     * @return string
     * @see CConsoleCommand::prompt()
     */
    public function prompt($message, $defaultValue)
    {
        if (!$this->interactive) {
            return $defaultValue;
        }
        return $this->migrateCommand->prompt($message);
    }

    /**
     * Executes a SQL statement. Silently. (only show sql on exception)
     * This method executes the specified SQL statement using {@link dbConnection}.
     * @param string $sql the SQL statement to be executed
     * @param array $params input parameters (name=>value) for the SQL execution. See {@link CDbCommand::execute} for more details.
     * @param boolean $verbose
     */
    public function execute($sql, $params = [], $verbose = true)
    {
        if ($verbose) {
            parent::execute($sql, $params);
        } else {
            try {
                echo "    > execute SQL ...";
                $time = microtime(true);
                $this->getDbConnection()->createCommand($sql)->execute($params);
                echo " done (time: " . sprintf('%.3f', microtime(true) - $time) . "s)\n";
            } catch (CException $e) {
                echo " failed.\n\n";
                throw $e;
            }
        }
    }
}
