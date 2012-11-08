<?php 
/**
* Arena::Block
*/

class Block extends Arena
{
  
  function __construct($attributes) {
    foreach($attributes as $k => $v) {
      $property = $k;
      $this->$property = $v;
    }
  }

  function css_class() {return strtolower($this->class);}
  function base_css_class() {return strtolower($this->base_class);}
  function is_image() {return $this->class == "Image";}
  function is_text() {return $this->class == "Text";}
  function is_embed() {return $this->class == "Media";}
  function is_link() {return $this->class == "Link";}
  function is_attachment() {return $this->class == "Attachment";}
  function is_channel() {return $this->class == "Channel";}
  function image_url($type) {return $this->image[$type]['url'];}

  function relative_time() {
    $date = $this->connected_at;

    $diff = time() - strtotime($date);
    if ($diff<60)
      return $diff . " second" . $this->plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<60)
      return $diff . " minute" . $this->plural($diff) . " ago";
    $diff = round($diff/60);
    if ($diff<24)
      return $diff . " hour" . $this->plural($diff) . " ago";
    $diff = round($diff/24);
    if ($diff<7)
      return $diff . " day" . $this->plural($diff) . " ago";
    $diff = round($diff/7);
    if ($diff<4)
      return $diff . " week" . $this->plural($diff) . " ago";
    return "on " . date("F j, Y", strtotime($date));
  }

  function plural($num) {
    if ($num != 1)
      return "s";
  }
}

?>