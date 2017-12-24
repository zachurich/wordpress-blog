<?php
/*
Plugin Name: Rest API Endpoint for Posts
Plugin URI: http://zachurich.com
Description: A starting point for creating Custom Wordpress API Endpoints
Author: Zach Urich
Version: 1.0
Author URI: http://zachurich.com
*/

class JSON_API_Endpoints {

    public function __construct() {
		add_action('rest_api_init', array($this, 'createRoutes'), 100);
		add_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );
    }

	function createRoutes() {
		require_once( 'inc/controllers/endpoint-controller.php' );
		require_once( 'inc/handlers/endpoint-handler.php' );

		// Args for WP_Query
		$postArgs = array(
			'post_type'      => 'post',
			'post_status' 	 => 'publish',
			'posts_per_page' => '-1',
			'orderby'        => 'date',
			'order'          => 'DESC'
		);

		// Data to return from within WP_Query
		function querySchema($postObj) {
			return array(
				"id"       => $postObj->ID,
				"slug"     => isset($postObj->post_name) ? $postObj->post_name : "",
				"title"    => get_the_title() ? get_the_title() : "",
				"date"     => get_the_date(),
				"excerpt"  => str_replace("&amp;", "&", get_the_excerpt()),
				"content"  => wpautop(get_the_content()),
				"link"     => get_permalink($postObj->ID),
				"imageURL" => isset(wp_get_attachment_image_src(get_post_thumbnail_id($postObj->ID), 'full')[0]) ? wp_get_attachment_image_src(get_post_thumbnail_id($postObj->ID), 'full')[0] : ""
			);
		}

		/* 
			1. Name of endpoint
			2. Arguments
			3. TODO: Parameters
		*/
		$postsController = new \Custom_Endpoint\Endpoint_Controller('posts', $postArgs, 'querySchema');
		$postsController->addRoutes();
	}

	/* Change Excerpt length */
	function custom_excerpt_length( $length ) {
		return 30;
	}

}

new JSON_API_Endpoints();
