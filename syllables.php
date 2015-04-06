<?php
/**
 * @since             0.1.0
 * @package           Syllables
 *
 * @wordpress-plugin
 * Plugin Name:       Syllables
 * Plugin URI:        https://gihub.com/goblindegook/Syllables
 * Description:       Syllables are helper classes and functions for WordPress development.
 * Version:           0.4.0
 * Author:            Luís Rodrigues
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       syllables
 * Domain Path:       /languages
 */

if ( file_exists( 'vendor/autoload.php' ) ) {
	require_once 'vendor/autoload.php';
}

if ( defined( 'ABSPATH' ) && file_exists( ABSPATH . '/vendor/autoload.php' ) ) {
	require_once ABSPATH . '/vendor/autoload.php';
}
