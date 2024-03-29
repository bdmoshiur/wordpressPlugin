<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf954f6cfa7232d45bc3fe0e09f4f3a5b
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Featured\\Posts\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Featured\\Posts\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitf954f6cfa7232d45bc3fe0e09f4f3a5b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf954f6cfa7232d45bc3fe0e09f4f3a5b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf954f6cfa7232d45bc3fe0e09f4f3a5b::$classMap;

        }, null, ClassLoader::class);
    }
}
