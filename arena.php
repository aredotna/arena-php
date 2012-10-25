<?php
function autoloader($class) {
  include 'lib/' . $class . '.php';
}
spl_autoload_register('autoloader');

/*
 * Arena PHP API interface
 * 
 *
 * Integration examples are  in examples/ directory
 *
*/

class Arena
{
  function __construct() {
    // empty for now
  }
  function get_channel($slug = null, $options = null){
    $request = new Request("channels/$slug", $options);
    return new Channel($request->data);
  }

  function get_block($id = null){
    $request = new Request("blocks/$id");
    return new Block($request->data);
  }

  function set_page() {
    if(isset($_GET['page'])){
      return $_GET['page'];
    }else{
      return 1;
    }
  }

}

?>