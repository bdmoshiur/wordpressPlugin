<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4504aa5e02d05cdd98b0551eeaa56d17
{
    public static $files = array (
        'e4ff99f3280e8636cb1ef03a860859fc' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Book\\Review\\Rewrite\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Book\\Review\\Rewrite\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4504aa5e02d05cdd98b0551eeaa56d17::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4504aa5e02d05cdd98b0551eeaa56d17::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}