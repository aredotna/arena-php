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

}

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