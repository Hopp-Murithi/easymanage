<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit3690da617cdd54c79525ff7b5ea17aaa
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

        spl_autoload_register(array('ComposerAutoloaderInit3690da617cdd54c79525ff7b5ea17aaa', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit3690da617cdd54c79525ff7b5ea17aaa', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit3690da617cdd54c79525ff7b5ea17aaa::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}