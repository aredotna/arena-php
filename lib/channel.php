<?php 

/**
* Arena::Channel
*/

class Channel extends Arena
{
  
  function __construct($attributes) {
  
    foreach($attributes as $k => $v) {
      $property = $k;
      $this->$property = $v;
    }
  
  }

  function each_channel_item($options, $template){
    if($options['sort'] == 'desc'){
        $this->contents = __::sortBy($this->contents, function($block) { return date('U',$block['updated_at']); });
    }
    __::each($this->contents, $template);
  }

}



?>

