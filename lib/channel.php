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
    $this->set_blocks();
  
  }

  function set_blocks() {
    for($i = 0; $i < count($this->contents); $i++){
      $this->contents[$i] = new Block($this->contents[$i]);
    }
  }


  function each_item($template) {
    __::each($this->contents, $template);
  }

  function set_sort_order($direction) {
    switch ($direction) {
      case 'asc':
        $this->contents = __::sortBy($this->contents, function($block) { return -strtotime($block->connected_at); });
        break;
      case 'desc':
        $this->contents = __::sortBy($this->contents, function($block) { return strtotime($block->connected_at); });
        break;
      case 'position':
        $this->contents = __::sortBy($this->contents, function($block) { return $block->position; });
        break;
    }

  }

}



?>

