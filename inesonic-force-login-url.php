<?php
/**
 * Plugin Name: Inesonic Force Login URL.
 * Plugin URI: http://www.inesonic.com
 * Description: A small proprietary plug-in forced the WordPress login URL.
 * Version: 1.0.0
 * Author: Inesonic, LLC
 * Author URI: http://www.inesonic.com
 */

/***********************************************************************************************************************
 * Copyright 2022, Inesonic, LLC.
 *
 * GNU Public License, Version 3:
 *   This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 *   License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any
 *   later version.
 *   
 *   This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *   warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 *   details.
 *   
 *   You should have received a copy of the GNU General Public License along with this program.  If not, see
 *   <https://www.gnu.org/licenses/>.
 ***********************************************************************************************************************
 */

/* Inesonic WordPress force login URL. */
class InesonicForceLoginUrl {
    const VERSION = '1.0.0';
    const SLUG    = 'inesonic-force-login-url';
    const NAME    = 'Inesonic Force Login URL';
    const AUTHOR  = 'Inesonic, LLC';
    const PREFIX  = 'InesonicForceLoginUrl';

    const LOGIN_SLUG = '/customer-sign-in/';

    private static $instance;  /* Plug-in instance */
    public static  $dir = '';  /* Plug-in directory */
    public static  $url = '';  /* Plug-in URL */

    /* Method that is called to initialize a single instance of the plug-in */
    public static function instance() {
        if (!isset(self::$instance)                                    &&
            !(self::$instance instanceof InesonicForceLoginUrl)    ) {
            self::$instance = new InesonicForceLoginUrl();
            self::$dir      = plugin_dir_path(__FILE__);
            self::$url      = plugin_dir_url(__FILE__);

            spl_autoload_register(array(self::$instance, 'autoloader'));
        }
    }


    /* This method ties the plug-in into the rest of the WordPress framework by adding hooks where needed. */
    public function __construct() {
        add_filter('login_url', array($this, 'force_login_url'), 1000, 3);
    }


    /* Optional methods for convenience. */
    public function autoloader($class_name) {
        if (!class_exists($class_name) and (FALSE !== strpos($class_name, self::PREFIX))) {
            $class_name = str_replace(self::PREFIX, '', $class_name);
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
            $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';

            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
    }


    /* Function that overrides WordPress' login URL */
    function force_login_url($login_url, $redirect, $force_reauth) {
        return home_url(self::LOGIN_SLUG);
    }
}

/* Function that returns the main plug-in instance. */
function inesonic_force_login_url() {
    return InesonicForceLoginUrl::instance();
}

inesonic_force_login_url();
