<?php 

/**
* Arena::User
*/

class User extends Arena
{
  
  function __construct($attributes) {
  
    foreach($attributes as $k => $v) {
      $property = $k;
      $this->$property = $v;
    }

  }
}



?>

