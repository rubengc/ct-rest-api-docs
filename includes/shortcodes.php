<?php
/**
 * Shortcodes
 *
 * @package     CT\Rest_API\Docs\Shortcodes
 * @author      GamiPress <contact@gamipress.com>, Ruben Garcia <rubengcdev@gmail.com>
 * @since       1.0.0
 */
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * [ct_rest_api_docs] shortcode
 *
 * @since 1.0.0
 *
 * @param array     $atts       Shortcode attributes
 * @param string    $content    Shortcode content
 *
 * @return string
 */
function ct_rest_api_docs_shortcode( $atts = array(), $content = '' ) {

    global $ct_registered_tables;

    $atts = shortcode_atts( array(
        'table' => '',
    ), $atts, 'ct_rest_api_docs' );

    if( empty( $atts['table'] ) ) {
        return __( 'Please, provide the table attribute.', 'ct-rest-api-docs' );
    }

    if( ! isset( $ct_registered_tables[$atts['table']] ) ) {
        return sprintf( __( 'Table "%s" not exists.', 'ct-rest-api-docs' ), $atts['table'] );
    }

    ct_setup_table( $atts['table'] );

    ob_start();
    include CT_REST_API_DOCS_DIR . 'templates/table-rest-api-docs.php';
    $ouput = ob_get_clean();

    return $ouput;

}
add_shortcode( 'ct_rest_api_docs' , 'ct_rest_api_docs_shortcode' );