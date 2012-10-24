

<?php
class ArenaAPI {
  /*
   * A Simple Class for abstracting common calls to the Arena API
   * and data manipulation tasks.
   * Returns values as associative arrays when possible
   *
   */ 

  # the base arena api url
  var $arena_api_url = 'http://api.are.na/v2/';

  #######
  ## BASIC API CALLS
  #######

  # base api request method
  function make_request($call_url){
    $json = file_get_contents($call_url);
    $data = json_decode($json, true);
    return $data;
  }

  function get_channel($channel_slug){    
    /* 
     * Returns a channel representation
     */ 
    $call_url = self::arena_api_url . 'channels/' . $channel_slug;
    return self::make_request($call_url);
  }

  function get_blocks_for_channel($channel, $page = Null, $per = Null){ 
    /*   
     * returns a dictionary: blocks, page, per, channel
     *
     * optional params are:
     *   depth: Defaults to public. Passing extended returns the available connections on a block
     *   page: Specifies the page of results to retrieve.
     *   per: Specifies the number of channels to retrieve.         
     */ 
    $call_url = $this->arena_api_url . 'blocks?channel=' . $channel;
    if(isset($per)){
      $call_url = $call_url . '&per=' . $per;
    }
    if(isset($page)){
      $call_url = $call_url . '&page=' . $page;            
    }
    if ($this->extended_depth == True){
     $call_url = $call_url . '&depth=extended';
   }
   return $this->make_request($call_url);
 }

 function get_user_channel($user,$page = Null, $per = Null){
    /*
    * returns an array: blocks, page, per, user
    *
    * optional params are:
    *    page: Specifies the page of results to retrieve.
    *    per: Specifies the number of channels to retrieve.
     */   
    $call_url = $this->arena_api_url.'channels?user='.$user;
    if(isset($per)){
      $call_url = $call_url . '&per=' . $per;
    }
    if(isset($page)){
      $call_url = $call_url . '&page=' . $page;            
    }
    return $this->make_request($call_url);
  }

  function get_block($block_identifier){
    /* 
     * takes an id or slug
     *
     * returns a block dict:
     *    provider_url,image_file_size, embed_source_url, updated_at, 
     * 
     *   embed_height, image_remote_url, block_type, id, user_id, 
     *   image_updated_at, title, comment_count, content, state, 
     *   image_thumb, provider_name, type, embed_width, username, 
     *   readable_updated_at, image_content_type, embed_url, description,
     *   embed_author_url, processing, embed_thumbnail_url, image_original,
     *   image_file_name, embed_html, embed_author_name, source_url, 
     *   image_display, user_slug, block_class, created_at, generated_title, 
     *   remote_source_url, embed_type, link_url, embed_title
     *
     * optional params are:
     *   depth: Defaults to public. Passing extended returns the available connections on a block
     */ 
    $call_url = $this->arena_api_url . 'blocks/' . $block_identifier;
    if ($this->extended_depth == True){
     $call_url = $call_url . '?depth=extended';
   }
   return $this->make_request($call_url);
 }

#######
## SORTING & ITEM RETRIEVAL FUNCTIONS
#######

#
# USER CHANNEL SPECIFIC FUNCTIONS
#
 function get_my_username(){    
    /* 
     * returns username as set in settings 
     */ 
    if (!$this->username){
      throw new Exception('Please provide a username slug in settings.php.');
    }    
    return $this->username;
  }

  function get_my_channels(){    
    /* 
     * returns all channels for the settings defined user as array 
     */
    if (!$sername){
      throw new Exception('Please provide a username slug in settings.php.');
    }        
    return $this->make_request($this->arena_api_url.'channels?user='.$this->username);
  }

#
# CHANNEL FUNCTIONS
#
  function get_channel_title($channel_array){ 
    return $channel_array['title'];
  }

  function get_channel_meta($channel_array){    
    /* 
    * returns metadata for an existing channel array 
    */ 
    function flatten($value) { return !is_array($value); }
    $channel_meta = array_filter($channel_array , 'flatten'); 
    return $channel_meta;
  }

  function get_channel_content($channel_array){ 
    /*
     *  returns channel blocks and sub-channels merged 
     */ 
    $content = array_merge($channel_array['blocks'], $channel_array['channels']);
    return $content;
  }

  function get_channel_channels($channel_array){ 
    return $channel_array['channels'];
  }

  function get_channel_channels_count($channel_array){ 
    return count($this->get_channel_channels($channel_array));
  }

  function get_channel_blocks($channel_array){ 
    return $channel_array['blocks'];
  }

  function get_channel_blocks_count($channel_array){ 
    return count($this->get_channel_blocks($channel_array));
  }

  function get_channel_connections($channel_array){
    /*
     * returns the unique connections of a channel
     */
    $blocks = $channel_array['blocks'];
    if (isset($blocks)){
      $connections = array();
      foreach($blocks as $block){
        if (isset($block['connections'])){    
          array_push($connections, $block['connections']);
        }
      }
      $flattened = __::flatten($connections, true);
      $uniques = array();
      foreach($flattened as $connection){
        if($connection['channel_id'] != $channel_array['id']){
          $uniques[$connection['channel']['id']] = $connection;
        }
      }
      return $uniques;
    } else {
      return Null;
    } 
  }

  function get_channel_connections_count($channel_array){
    return count($this->get_channel_connections($channel_array));    
  }

#
# BLOCK FUNCTIONS
#
  function sort_blocks_by_created($blocks_array, $sort_by ='desc'){
    if($sort_by == 'asc'){
      return __::sortBy($blocks_array, function($block) { return $block['created_at']; });
    }
    $dates = array();
    foreach ($blocks_array as $key => $row) {
      $dates[$key]  = $row['created_at']; 
    }
    array_multisort($dates, SORT_DESC, $blocks_array);
    return $blocks_array;
  }

  function get_image_blocks($blocks_array){
    return __::filter($blocks_array, function($block) { return $block['block_class'] == 'image'; });    
  }

  function get_image_blocks_count($blocks_array){
    return count($this->get_image_blocks($blocks_array));    
  }

  function get_media_blocks($blocks_array){
    return __::filter($blocks_array, function($block) { return $block['block_class'] == 'media'; });    
  }

  function get_media_blocks_count($blocks_array){
    return count($this->get_media_blocks($blocks_array));    
  }

  function get_link_blocks($blocks_array){
    return __::filter($blocks_array, function($block) { return $block['block_class'] == 'link'; });    
  }

  function get_link_blocks_count($blocks_array){
    return count($this->get_link_blocks($blocks_array));    
  }

  function get_text_blocks($blocks_array){
    return __::filter($this->get_channel_blocks($channel_array), function($block) { return $block['block_class'] == 'text'; });    
  }

  function get_text_blocks_count($blocks_array){
    return count($this->get_text_blocks($blocks_array));    
  }

  function get_connections_for_block($block_array){
    return $block_array['connections'];
  }

  function get_block_class($block_array){
    return $block_array['block_class'];
  }


} # END ARENA API CLASS 


# debug stuff
function pretty_print_array($array){
  /*
   * Print out an array for easily seeing keys/values 
   */
  __::each($array, function($key, $value) {
    $key_type = (gettype($key));
    $val_type = (gettype($value));
    echo('<div style="text-align:left;">');

    if($key_type == "array"){
      echo ('<b>[' . $value . ']</b>');
      echo ('<div style="margin-left:25px;">');
      pretty_print_array($key); 
      echo ('</div>');    
    } else {
      echo ('<div>');
      echo ('<b>[' . $value . ']</b>');
      echo (': ');
      echo ($key);
      echo ('<br />');
      echo ('</div>');    
    }    
    echo("</div>");

  });
}

?>
