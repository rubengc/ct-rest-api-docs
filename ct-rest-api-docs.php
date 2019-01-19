<?php
/**
 * Plugin Name:     	Custom Tables - Rest API Docs
 * Plugin URI:      	https://gamipress.com
 * Description:     	Rest API docs generator for Custom Tables (CT).
 * Version:         	1.0.0
 * Author:          	GamiPress
 * Author URI:      	https://gamipress.com/
 * Text Domain:     	ct-rest-api-docs
 * Domain Path: 		/languages/
 * Requires at least: 	4.4
 * Tested up to: 		5.0
 * License:         	GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         	CT\Rest_API\Docs
 * @author          	GamiPress <contact@gamipress.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @copyright       	Copyright (c) GamiPress
 */

/*
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Affero General
 * Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

final class CT_Rest_API_Docs {

    /**
     * @var         CT_Rest_API_Docs $instance The one true CT_Rest_API_Docs
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      CT_Rest_API_Docs self::$instance The one true CT_Rest_API_Docs
     */
    public static function instance() {

        if( ! self::$instance ) {

            self::$instance = new CT_Rest_API_Docs();
            self::$instance->constants();
            self::$instance->includes();
            self::$instance->hooks();
            self::$instance->load_textdomain();

        }

        return self::$instance;

    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {

        // Plugin version
        define( 'CT_REST_API_DOCS_VER', '1.0.0' );

        // Plugin file
        define( 'CT_REST_API_DOCS_FILE', __FILE__ );

        // Plugin path
        define( 'CT_REST_API_DOCS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'CT_REST_API_DOCS_URL', plugin_dir_url( __FILE__ ) );

    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            require_once CT_REST_API_DOCS_DIR . 'includes/shortcodes.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {

        // Setup our activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'admin_notices', array( $this, 'admin_notices' ) );

    }

    /**
     * Activation hook for the plugin.
     */
    function activate() {

    }

    /**
     * Deactivation hook for the plugin.
     */
    function deactivate() {

    }

    /**
     * Plugin admin notices.
     *
     * @since  1.0.0
     */
    public function admin_notices() {

        if ( ! $this->meets_requirements() && ! defined( 'CT_REST_API_DOCS_ADMIN_NOTICES' ) ) : ?>

            <div id="message" class="notice notice-error is-dismissible">
                <p>
                    <?php printf(
                        __( 'Custom Tables -Rest API Docs Generator requires %s library in order to work. Please install and activate it.', 'ct-rest-api-docs' ),
                        '<a href="https://github.com/rubengc/ct" target="_blank">Custom Tables</a>'
                    ); ?>
                </p>
            </div>

            <?php define( 'CT_REST_API_DOCS_ADMIN_NOTICES', true ); ?>

        <?php endif;

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( ! class_exists( 'CT' ) ) {
            return false;
        }

        return true;

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = CT_REST_API_DOCS_DIR . '/languages/';
        $lang_dir = apply_filters( 'ct_rest_api_docs_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'ct-rest-api-docs' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'ct-rest-api-docs', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/ct-rest-api-docs/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/gamipress/ folder
            load_textdomain( 'ct-rest-api-docs', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/gamipress/languages/ folder
            load_textdomain( 'ct-rest-api-docs', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'ct-rest-api-docs', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true CT_Rest_API_Docs instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \CT_Rest_API_Docs The one true CT_Rest_API_Docs
 */
function ct_rest_api_docs_generator() {
    return CT_Rest_API_Docs::instance();
}
add_action( 'init', 'ct_rest_api_docs_generator', 999 ); // Important: plugin need to be loaded on init