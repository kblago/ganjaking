<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb1fb2deee2ba133d5d778b52c627db26
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SkyVerge\\WooCommerce\\Checkout_Add_Ons\\' => 38,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SkyVerge\\WooCommerce\\Checkout_Add_Ons\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb1fb2deee2ba133d5d778b52c627db26::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb1fb2deee2ba133d5d778b52c627db26::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
