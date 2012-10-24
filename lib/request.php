<?php 

/**
* Arena::Request
*/

class Request {

  function __construct($path, $args = null) {
    include 'settings.php';

    $base_url = 'http://api.are.na/v2/';
    $url = $base_url . $path;
    
    $this->request = curl_init($url);
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    
    // set X-AUTH-TOKEN if defined
    if ($config['auth_token'] !== ''){
      curl_setopt($this->request, CURLOPT_HTTPHEADER, array('X-AUTH-TOKEN: '.$config['auth_token']));
    }

    $this->data = curl_exec($this->request);
    curl_close($this->request);

    if($this->data !== null){
      $this->data = json_decode($this->data, true);
      return $this;
    }
  }

}

?>