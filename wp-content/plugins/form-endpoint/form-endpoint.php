<?php
/*
Plugin Name: Rest API Endpoint for Form Collection
Plugin URI: http://zachurich.com
Description: Endpoint for Posting Form Data
Author: Zach Urich
Version: 1.0
Author URI: http://zachurich.com
*/

include_once('inc/CPT.php');
include_once('inc/entry-fields.php');

class Form_API_Endpoints {

    public function __construct() {
        add_action('rest_api_init', array($this, 'addRoutes'), 100);
        add_action( 'plugins_loaded', array($this, 'formEntryCPT') );
    }

    function formEntryCPT() {
        $entries = new CPT(array(
            'post_type_name' => 'entry',
            'singular'       => 'Entry',
            'plural'         => 'Entries',
            'slug'           => 'entry'
        ));

        $entries->menu_icon("dashicons-admin-comments");
    }
    
    public function addRoutes() {
        $namespace = 'custom/v1';
        register_rest_route( $namespace, '/contact', array(
            'methods'  => 'POST',
            'callback' => array($this, 'createResponse')
        ));
        
    }
    
    function createResponse($req) {
        $name    = esc_html( $req->get_param( 'name' ) );
        $email   = esc_html( $req->get_param( 'email' ) );
        $inquiry = esc_html( $req->get_param( 'inquiry' ) );
        $headers = $req->get_headers();
        $origin = $headers['origin'];

        $this->debugRes($name, $email, $inquiry, $origin, $headers);
        if ( $origin && $origin[0] == 'http://localhost:8080' ) {
            $this->createEntry($name, $email, $inquiry);
        }
    }

    private function createEntry($name, $email, $inquiry) {
        $args = array(
            'post_type'    => 'entry',
            'post_title'   => $name,
            'post_content' => $inquiry
        );

        $entryID = wp_insert_post($args);

        update_field('submission_name', $name, $entryID);
        update_field('submission_email', $email, $entryID);
        update_field('submission_inquiry', $inquiry, $entryID);

    }

    // Just for debugging :)
    private function debugRes($name, $email, $inquiry, $origin, $headers) {
        $file = 'entries.txt';
        $file = WP_PLUGIN_DIR . "/form-endpoint/entries.txt"; 

        $current = file_get_contents($file);
        $current .= 'Headers: ' . json_encode($headers) . "\n";
        $current .= 'Name: ' . json_encode($name) . "\n";
        $current .= 'Origin: ' . json_encode($origin) . "\n";
        $current .= 'Email: ' . json_encode($email) . "\n";
        $current .= 'Inquiry: ' . json_encode($inquiry) . "\n";
        $current .= "\n";
        // Write the contents back to the file
        file_put_contents($file, $current);
    }

}

new Form_API_Endpoints();
