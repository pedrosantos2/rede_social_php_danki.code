<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd43848d8dcb9207cee88b2c25d890392
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitd43848d8dcb9207cee88b2c25d890392', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd43848d8dcb9207cee88b2c25d890392', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd43848d8dcb9207cee88b2c25d890392::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
