<?php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Autoloads Twig Extensions classes.
 *
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 */
class Twig_Extensions_Autoloader
{
    /**
     * Registers Twig_Extensions_Autoloader as an SPL autoloader.
     */
    public static function register()
    {
        spl_autoload_register(array(new self(), 'autoload'));
    }

    /**
     * Handles autoloading of classes.
     *
     * @param string $class A class name.
     *
     * @return bool Returns true if the class has been loaded
     */
    public static function autoload($class)
    {
        if (0 !== strpos($class, 'Twig_Extensions')) {
            return;
        }

        if (file_exists($file = dirname(__FILE__).'/../../'.str_replace('_', '/', $class).'.php')) {
            require $file;
        }
    }
}
