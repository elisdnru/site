<?php /** @noinspection ALL */

declare(strict_types=1);

use yii\BaseYii;

class Yii extends BaseYii
{
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
