<?php

/**
 * EMigrateCommand manages the database migrations.
 *
 * This class is an extension to yiis db migration command.
 *
 * It adds the following features:
 *  - module support
 *    you can create migrations in different modules
 *    so you are able to disable modules and also having their
 *    database tables removed/never set up
 *    yiic migrate to m000000_000000 --module=examplemodule
 *
 *  - module dependencies (planned, not yet implemented)
 *
 * @link http://www.yiiframework.com/extension/extended-database-migration/
 * @link http://www.yiiframework.com/doc/guide/1.1/en/database.migration
 * @author Carsten Brandt <mail@cebe.cc>
 * @version 0.8.0-dev
 */

namespace app\extensions\migrate;

use CDbCommand;
use CDbConnection;
use CDbCriteria;
use CHtml;
use MigrateCommand;
use Yii;

Yii::import('system.cli.commands.MigrateCommand');

/**
 * EMigrateCommand manages the database migrations.
 *
 * @property array|null $modulePaths list of all modules
 * @property array $enabledModulePaths list of all enabled modules
 * @property array $disabledModules list of all disabled modules names
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @version 0.7.1
 */
class EMigrateCommand extends MigrateCommand
{
    /**
     * @var string|null the current module(s) to use for current command (comma separated list)
     * defaults to null which means all modules are used
     * examples:
     * --module=core
     * --module=core,user,admin
     */
    public $module;

    /**
     * @var string the application core is handled as a module named 'core' by default
     */
    public $applicationModuleName = 'core';

    /**
     * @var string delimiter for modulename and migration name for display
     */
    public $moduleDelimiter = ': ';

    /**
     * @var string subdirectory to use for migrations in Yii alias format
     * this is only used if you do not set modulePath explicitly {@see setModulePaths()}
     */
    public $migrationSubPath = 'migrations';

    /**
     * @var array|null list of all modules
     * @see getModulePaths()
     * @see setModulePaths()
     */
    private $internalModulePaths;
    private $internalRunModulePaths; // modules for current run

    /**
     * @var array
     * @see getDisabledModules()
     * @see setDisabledModules()
     */
    private $internalDisabledModules = [];

    /**
     * @return array list of all modules
     */
    public function getModulePaths()
    {
        if ($this->internalModulePaths === null) {
            $this->internalModulePaths = [];
            foreach (Yii::app()->modules as $module => $config) {
                if (is_array($config)) {
                    $alias = 'application.modules.' . $module . '.' . ltrim($this->migrationSubPath, '.');
                    if (isset($config['class'])) {
                        Yii::setPathOfAlias(
                            $alias,
                            Yii::getPathOfAlias('application.modules.' . $module) . '/' .
                            str_replace('.', '/', ltrim($this->migrationSubPath, '.'))
                        );
                    } elseif (isset($config['basePath'])) {
                        Yii::setPathOfAlias(
                            $alias,
                            $config['basePath'] . '/' .
                            str_replace('.', '/', ltrim($this->migrationSubPath, '.'))
                        );
                    }
                    $this->internalModulePaths[$module] = $alias;
                    $path = Yii::getPathOfAlias($alias);
                    if ($path === false || !is_dir($path)) {
                        $this->internalDisabledModules[] = $module;
                    }
                } else {
                    $this->internalModulePaths[$config] = 'application.modules.' . $config . '.' . ltrim($this->migrationSubPath, '.');
                }
            }
        }
        // add a pseudo-module 'core'
        $this->internalModulePaths[$this->applicationModuleName] = $this->migrationPath;
        $path = Yii::getPathOfAlias($this->migrationPath);
        if ($path === false || !is_dir($path)) {
            $this->internalDisabledModules[] = $this->applicationModuleName;
        }
        return $this->internalModulePaths;
    }

    /**
     * @var array|null list of all modules
     * If set to null, which is default, yii applications module config will be used
     * If modules are taken from yii application config, all entries will be
     * 'moduleName' => 'application.modules.<moduleName>.migrations',
     * You can change the subpath name by setting {@see migrationSubPath} which is 'migrations' per default.
     * If 'class' or 'basePath' are set in module config the above path alias is
     * adjusted to class/basePath with {@see Yii::setPathOfAlias()}.
     *
     * example:
     * array(
     *      'moduleName' => 'application.modules.moduleName.db.migrations',
     * )
     */
    public function setModulePaths($modulePaths)
    {
        $this->internalModulePaths = $modulePaths;
    }

    /**
     * @return array list of all disabled modules names
     */
    public function getDisabledModules()
    {
        // make sure modules are initialized
        $this->getModulePaths();
        foreach ($this->internalDisabledModules as $module) {
            if (!array_key_exists($module, $this->modulePaths)) {
                unset($this->internalDisabledModules[$module]);
            }
        }
        return array_unique($this->internalDisabledModules);
    }

    /**
     * @param array $modules list of all disabled modules names
     * you can add modules here to temporarily disable them
     * array(
     *      'examplemodule1',
     *      'examplemodule2',
     *      ...
     * )
     */
    public function setDisabledModules($modules)
    {
        $this->internalDisabledModules = is_array($modules) ? $modules : [];
    }

    /**
     * @return array list of all enabled modules
     */
    public function getEnabledModulePaths()
    {
        $modules = $this->getModulePaths();
        foreach ($this->getDisabledModules() as $module) {
            unset($modules[$module]);
        }
        return $modules;
    }

    /**
     * prepare paths before any action
     *
     * @param $action
     * @param $params
     * @return bool
     */
    public function beforeAction($action, $params)
    {
        $tmpMigrationPath = $this->migrationPath;
        $this->migrationPath = 'application';
        if (parent::beforeAction($action, $params)) {
            $this->migrationPath = $tmpMigrationPath;

            echo "extended with EMigrateCommand by cebe <mail@cebe.cc>\n\n";

            // check --module parameter
            if ($action === 'create' && $this->module !== null) {
                $this->usageError('create command can not be called with --module parameter!');
            }
            if ($this->module !== null && !is_string($this->module)) {
                $this->usageError('parameter --module must be a comma seperated list of modules or a single module name!');
            }

            // inform user about disabled modules
            if (!empty($this->disabledModules)) {
                echo 'The following modules are disabled: ' . implode(', ', $this->disabledModules) . "\n";
            }

            // only add modules that are desired by command
            $modules = false;
            if ($this->module !== null) {
                $modules = explode(',', $this->module);

                // error if specified module does not exist
                foreach ($modules as $module) {
                    if (in_array($module, $this->disabledModules, true)) {
                        echo "\nError: module '$module' is disabled!\n\n";
                        exit(1);
                    }
                    if (!isset($this->enabledModulePaths[$module])) {
                        echo "\nError: module '$module' is not available!\n\n";
                        exit(1);
                    }
                }
                echo 'Current call is limited to module' . (count($modules) > 1 ? 's' : '') . ': ' . implode(', ', $modules) . "\n";
            }
            echo "\n";

            // initialize modules
            foreach ($this->getEnabledModulePaths() as $module => $pathAlias) {
                if ($modules === false || in_array($module, $modules, true)) {
                    Yii::import($pathAlias . '.*');
                    $this->internalRunModulePaths[$module] = $pathAlias;
                }
            }
            return true;
        }
        return false;
    }

    public function actionCreate($args)
    {
        // if module is given adjust path
        if (count($args) === 2) {
            if (!isset($this->modulePaths[$args[0]])) {
                echo "\nError: module '{$args[0]}' is not available!\n\n";
                return 1;
            }
            $this->migrationPath = Yii::getPathOfAlias($this->modulePaths[$args[0]]);
            $args = [$args[1]];
        } else {
            $this->migrationPath = Yii::getPathOfAlias($this->modulePaths[$this->applicationModuleName]);
        }
        if (!is_dir($this->migrationPath)) {
            echo "\nError: '{$this->migrationPath}' does not exist or is not a directory!\n\n";
            return 1;
        }
        return parent::actionCreate($args);
    }

    public function actionUp($args)
    {
        $this->internalScopeAddModule = true;
        $exitCode = parent::actionUp($args);
        $this->internalScopeAddModule = false;
        return $exitCode;
    }

    public function actionDown($args)
    {
        $this->internalScopeAddModule = true;
        $exitCode = parent::actionDown($args);
        $this->internalScopeAddModule = false;
        return $exitCode;
    }

    public function actionTo($args)
    {
        $this->internalScopeAddModule = false;
        $exitCode = parent::actionTo($args);
        $this->internalScopeAddModule = true;
        return $exitCode;
    }

    public function actionMark($args)
    {
        // migrations that need to be updated after command
        $migrations = $this->getNewMigrations();

        // run mark action
        $this->internalScopeAddModule = false;
        $exitCode = parent::actionMark($args);
        $this->internalScopeAddModule = true;

        // update migration table with modules
        /** @var CDbCommand $command */
        $command = $this->getDbConnection()->createCommand()
            ->select('version')
            ->from($this->migrationTable)
            ->where('module IS NULL');

        foreach ($command->queryColumn() as $version) {
            $module = null;
            foreach ($migrations as $migration) {
                [$module, $migration] = explode($this->moduleDelimiter, $migration);
                if ($migration === $version) {
                    break;
                }
            }

            $this->ensureBaseMigration($module);

            $this->getDbConnection()->createCommand()->update(
                $this->migrationTable,
                ['module' => $module],
                'version=:version',
                [':version' => $version]
            );
        }
        return $exitCode;
    }

    protected function instantiateMigration($class)
    {
        require_once($class . '.php');
        $migration = new $class;
        $migration->setDbConnection($this->getDbConnection());
        if ($migration instanceof EDbMigration) {
            /** @var EDbMigration $migration */
            $migration->setCommand($this);
        }
        return $migration;
    }

    // set to not add modules when getHistory is called for getNewMigrations
    private $internalScopeNewMigrations = false;
    private $internalScopeAddModule = true;

    protected function getNewMigrations()
    {
        $this->internalScopeNewMigrations = true;
        $migrations = [];
        // get new migrations for all new modules
        foreach ($this->internalRunModulePaths as $module => $path) {
            $this->migrationPath = Yii::getPathOfAlias($path);
            foreach (parent::getNewMigrations() as $migration) {
                if ($this->internalScopeAddModule) {
                    $migrations[$migration] = $module . $this->moduleDelimiter . $migration;
                } else {
                    $migrations[$migration] = $migration;
                }
            }
        }
        $this->internalScopeNewMigrations = false;

        ksort($migrations);
        return array_values($migrations);
    }

    protected function getMigrationHistory($limit)
    {
        /** @var CDbConnection $db */
        $db = $this->getDbConnection();

        // avoid getTable trying to hit a db cache and die in endless loop
        $db->schemaCachingDuration = 0;
        Yii::app()->coreMessages->cacheID = false;

        if ($db->schema->getTable($this->migrationTable) === null) {
            echo 'Creating migration history table "' . $this->migrationTable . '"...';
            $db->createCommand()->createTable($this->migrationTable, [
                'version' => 'string NOT NULL PRIMARY KEY',
                'apply_time' => 'integer',
                'module' => 'VARCHAR(32)',
            ]);
            echo "done.\n";
        }

        if ($this->internalScopeNewMigrations || !$this->internalScopeAddModule) {
            $select = 'version AS version_name, apply_time';
            $params = [];
        } else {
            /*
             * switch concat functions for different db systems
             * please let me know if your system is not switched
             * correctly here. File a bug here:
             * https://github.com/yiiext/migrate-command/issues
             */
            switch ($db->getDriverName()) {
                case 'mysql':
                    $select = 'CONCAT(module, :delimiter, version) AS version_name, apply_time';
                    break;
                case 'mssql': // http://msdn.microsoft.com/en-us/library/aa276862%28v=sql.80%29.aspx
                case 'sqlsrv':
                case 'cubrid': // http://www.cubrid.org/manual/840/en/Concatenation%20Operator
                    $select = '(module + :delimiter + version) AS version_name, apply_time';
                    break;
                default: // SQL-ANSI default: sqlite, firebird, ibm, informix, oci, pgsql, sqlite, sqlite2
                    // not sure what to do with odbc
                    $select = '(module || :delimiter || version) AS version_name, apply_time';
            }
            $params = [':delimiter' => $this->moduleDelimiter];
        }

        $command = $db->createCommand()
            ->select($select)
            ->from($this->migrationTable)
            ->order('version DESC')
            ->limit($limit);

        if ($this->module !== null) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('module', explode(',', $this->module));
            $command->where = $criteria->condition;
            $params += $criteria->params;
        }

        return CHtml::listData($command->queryAll(true, $params), 'version_name', 'apply_time');
    }

    /**
     * create base migration for module if none exists
     *
     * @param $module
     * @return void
     */
    protected function ensureBaseMigration($module)
    {
        $baseName = self::BASE_MIGRATION . '_' . $module;
        /** @var CDbConnection $db */
        $db = $this->getDbConnection();
        if (!$db->createCommand()->select('version')
            ->from($this->migrationTable)
            ->where('module=:module AND version=:version')
            ->queryRow(true, [':module' => $module, 'version' => $baseName])) {
            $db->createCommand()->insert(
                $this->migrationTable,
                [
                    'version' => $baseName,
                    'apply_time' => time(),
                    'module' => $module,
                ]
            );
        }
    }

    protected function migrateUp($class)
    {
        $module = $this->applicationModuleName;
        // remove module if given
        if (($pos = mb_strpos($class, $this->moduleDelimiter)) !== false) {
            $module = mb_substr($class, 0, $pos);
            $class = mb_substr($class, $pos + mb_strlen($this->moduleDelimiter));
        }

        $this->ensureBaseMigration($module);

        if (mb_strpos($class, self::BASE_MIGRATION) === 0) {
            return null;
        }
        if (($ret = parent::migrateUp($class)) !== false) {
            // add module information to migration table
            $this->getDbConnection()->createCommand()->update(
                $this->migrationTable,
                ['module' => $module],
                'version=:version',
                [':version' => $class]
            );
        }
        return $ret;
    }

    protected function migrateDown($class)
    {
        // remove module if given
        if (($pos = mb_strpos($class, $this->moduleDelimiter)) !== false) {
            $class = mb_substr($class, $pos + mb_strlen($this->moduleDelimiter));
        }

        if (mb_strpos($class, self::BASE_MIGRATION) !== 0) {
            return parent::migrateDown($class);
        }

        return null;
    }

    public function getHelp()
    {
        return parent::getHelp() . <<<EOD

EXTENDED USAGE EXAMPLES (with modules)
  for every action except create you can specify the modules to use
  with the parameter --module=<modulenames>
  where <modulenames> is a comma seperated list of module names (or a single name)

 * yiic migrate create modulename create_user_table
   Creates a new migration named 'create_user_table' in module 'modulename'.

  all other commands work exactly as described above.

EOD;
    }

    protected function getTemplate()
    {
        if ($this->templateFile !== null) {
            return parent::getTemplate();
        }
        return str_replace('CDbMigration', '\\' . EDbMigration::class, parent::getTemplate());
    }
}
