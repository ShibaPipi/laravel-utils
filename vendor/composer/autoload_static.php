<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit52d6cb091830f08675f717a0f04e7546
{
    public static $files = array (
        'b59d0e82c2da915917826f8d5526b1ba' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Shibapipi\\Utils\\Tests\\' => 22,
            'Shibapipi\\Utils\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Shibapipi\\Utils\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Shibapipi\\Utils\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit52d6cb091830f08675f717a0f04e7546::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit52d6cb091830f08675f717a0f04e7546::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}