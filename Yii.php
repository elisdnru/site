<?php /** @noinspection ALL */

declare(strict_types=1);

use yii\BaseYii;

class Yii extends BaseYii
{
    private static $_aliases = array('system' => YII_PATH, 'zii' => YII_ZII_PATH);

    private static $_app;

    public static function app(): CApplication
    {
        if (self::$_app === null) {
            self::$_app = new CWebApplication([
                'basePath' => __DIR__,
            ]);
        }
        return self::$_app;
    }

    public static function setApplication($app)
    {
        if (self::$_app === null || $app === null) {
            self::$_app = $app;
        } else {
            throw new CException('Yii application can only be created once.');
        }
    }

    public static function setPathOfAlias($alias,$path)
    {
        if(empty($path))
            unset(self::$_aliases[$alias]);
        else
            self::$_aliases[$alias]=rtrim($path,'\\/');
    }

    public static function getPathOfAlias($alias)
    {
        if (isset(self::$_aliases[$alias]))
            return self::$_aliases[$alias];
        elseif (($pos = strpos($alias, '.')) !== false) {
            $rootAlias = substr($alias, 0, $pos);
            if (isset(self::$_aliases[$rootAlias]))
                return self::$_aliases[$alias] = rtrim(self::$_aliases[$rootAlias] . DIRECTORY_SEPARATOR . str_replace('.', DIRECTORY_SEPARATOR, substr($alias, $pos + 1)), '*' . DIRECTORY_SEPARATOR);
            elseif (self::$_app instanceof CWebApplication) {
                if (self::$_app->findModule($rootAlias) !== null)
                    return self::getPathOfAlias($alias);
            }
        }
        return false;
    }

    public static function log($message, $level, $category)
    {
        Yii::getLogger()->log($message, $level, $category);
    }

    public static function createComponent($config)
    {
        return Yii::createObject($config);
    }

    /**
     * Registers a new class autoloader.
     * The new autoloader will be placed before {@link autoload} and after
     * any other existing autoloaders.
     * @param callback $callback a valid PHP callback (function name or array($className,$methodName)).
     * @param boolean $append whether to append the new autoloader after the default Yii autoloader.
     * Be careful using this option as it will disable {@link enableIncludePath autoloading via include path}
     * when set to true. After this the Yii autoloader can not rely on loading classes via simple include anymore
     * and you have to {@link import} all classes explicitly.
     */
    public static function registerAutoloader($callback, $append = false)
    {
        if ($append) {
            self::$enableIncludePath = false;
            spl_autoload_register($callback);
        } else {
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            spl_autoload_register($callback);
            spl_autoload_register(array('YiiBase', 'autoload'));
        }
    }
}
