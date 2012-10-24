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

  function each_channel_item($template) {
    __::each($this->contents, $template);
  }

  function set_sort_order($direction) {
    switch ($direction) {
      case 'asc':
        $this->contents = __::sortBy($this->contents, function($block) { return -strtotime($block['connected_at']); });
        break;
      case 'desc':
        $this->contents = __::sortBy($this->contents, function($block) { return strtotime($block['connected_at']); });
        break;
      case 'position':
        $this->contents = __::sortBy($this->contents, function($block) { return $block['position']; });
        break;
    }

  }

}



?>

