<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitea4f549cbffc28342e7403d920cd2313
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Woo\\Multipart\\Form\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Woo\\Multipart\\Form\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitea4f549cbffc28342e7403d920cd2313::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitea4f549cbffc28342e7403d920cd2313::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitea4f549cbffc28342e7403d920cd2313::$classMap;

        }, null, ClassLoader::class);
    }
}