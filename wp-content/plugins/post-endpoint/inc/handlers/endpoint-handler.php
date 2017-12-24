<?php
namespace Custom_Endpoint;
use WP_Query;

class Endpoint_Handler {

  function __construct($endpointArgs = NULL, $querySchema = NULL) {
    $this->endpointArgs = $endpointArgs;
    $this->querySchema = $querySchema;
  }

  public function getData() {
    $data = array();

    $args = $this->endpointArgs;
    $schema = $this->querySchema;

    $dataQuery = new WP_Query( $args );

    if ( $dataQuery->have_posts() ) {
        while ( $dataQuery->have_posts() ) {
            global $post;
            $dataQuery->the_post();
            setup_postdata( $post );
            array_push($data, $schema($post));
        }
        wp_reset_postdata();
    }

    $payload = array( 'items' => $data );

    return $payload;
  }

}
?>
