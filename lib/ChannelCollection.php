<?php 

/**
* Arena::ChannelCollection
*/

class ChannelCollection extends Arena
{
  
  function __construct($attributes) {
  
    foreach($attributes as $k => $v) {
      $property = $k;
      $this->$property = $v;
    }
    $this->set_channels();
  }

  function each_channel($template) {
    __::each($this->channels, $template);
  }

  function set_channels(){
    for($i = 0; $i < count($this->channels); $i++){
      $this->channels[$i] = new Channel($this->channels[$i]);
    }
  }
}



?>

