<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit65a6d9c2813331bf6be1bf10cdda1cba
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

        spl_autoload_register(array('ComposerAutoloaderInit65a6d9c2813331bf6be1bf10cdda1cba', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit65a6d9c2813331bf6be1bf10cdda1cba', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit65a6d9c2813331bf6be1bf10cdda1cba::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
