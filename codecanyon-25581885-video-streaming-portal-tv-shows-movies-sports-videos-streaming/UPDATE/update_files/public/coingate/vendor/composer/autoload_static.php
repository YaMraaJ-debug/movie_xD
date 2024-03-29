<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit21d29ab2bf0a4786a87bee931da459a8
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CoinGate\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CoinGate\\' => 
        array (
            0 => __DIR__ . '/..' . '/coingate/coingate-php/lib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit21d29ab2bf0a4786a87bee931da459a8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit21d29ab2bf0a4786a87bee931da459a8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit21d29ab2bf0a4786a87bee931da459a8::$classMap;

        }, null, ClassLoader::class);
    }
}
