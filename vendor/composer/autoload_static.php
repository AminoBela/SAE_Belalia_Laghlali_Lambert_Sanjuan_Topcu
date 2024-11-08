<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7dbdd9239f83ec9aad7ae0c303576462
{
    public static $prefixLengthsPsr4 = array (
        'i' => 
        array (
            'iutnc\\nrv\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'iutnc\\nrv\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7dbdd9239f83ec9aad7ae0c303576462::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7dbdd9239f83ec9aad7ae0c303576462::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7dbdd9239f83ec9aad7ae0c303576462::$classMap;

        }, null, ClassLoader::class);
    }
}