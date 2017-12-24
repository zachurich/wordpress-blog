<?php
namespace Custom_Endpoint;

class Endpoint_Controller {

  /*
  * PARAMS:
  * 1. endpointName: Name of endpoint to create (string)
  * 2. endpointArgs: Arguments for getting data (array)
  * 3. dataSchema: Schema for shape of response (array)
  */

  function __construct( $endpointName = NULL, $endpointArgs = NULL, $querySchema = NULL ) {
    $this->endpointName = $endpointName;
    $this->endpointArgs = $endpointArgs;
    $this->querySchema = $querySchema;
  }


  public function addRoutes() {
    $namespace = 'custom/v1';
    register_rest_route( $namespace, '/' . $this->endpointName, array(
      'methods'  => 'GET',
      'callback' => array($this, 'createResponse')
    ));
  }

  //  function handleParams($req) {
  //   $request = $req->get_params();
  //   return $request;
  // }

  function createResponse($req) {
    // var_dump($this->handleParams($req));  
    $handler = new Endpoint_Handler($this->endpointArgs, $this->querySchema);
    $data = $handler->getData();

    return new \WP_REST_Response($data, 200);
  }

}
