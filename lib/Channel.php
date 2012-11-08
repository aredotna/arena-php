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
    if(isset($this->contents)){
      for($i = 0; $i < count($this->contents); $i++){
        $this->contents[$i] = new Block($this->contents[$i]);
      }
    }
  }

  function filter_unselected() {
    $this->contents = __::filter($this->contents, function($block){ return $block->selected === true; });
  }

  function each_item($template) {
    __::each($this->contents, $template);
  }

  function each_page($current_page, $template) {
    if($this->total_pages > 1){
      for ($i=1; $i < $this->total_pages; $i++) {
        call_user_func($template, $i, $current_page);
      }
    }
  }

  function authors_to_sentence() {
    if(count($this->collaborators)){
      $str = $this->user['username'];
      $collaborators = $this->collaborators;
      $last_one = array_pop($collaborators);
      if(count($collaborators)){
        foreach ($collaborators as $collaborator) {
          $str .= ", " . $collaborator['username'];
        }
      }
      $str .= " and " . $last_one['username'];
      return $str;
    }else{
      return $this->user['username'];
    }
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

