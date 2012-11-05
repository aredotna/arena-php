<?php
/*
 * Arena POST Image data example
 * 
 * 
 * (Canvas to POST code from: http://permadi.com/blog/2010/10/html5-saving-canvas-image-data-using-php-and-ajax/)
 */

$slug = 'drawings';

  if (isset($GLOBALS["HTTP_RAW_POST_DATA"])){

    // save image data to file
    $imageData = $GLOBALS['HTTP_RAW_POST_DATA'];
    $filteredData = substr($imageData, strpos($imageData, ",")+1);
    $unencodedData = base64_decode($filteredData);
    $fp = fopen('test.png', 'wb');
    fwrite($fp, $unencodedData);
    fclose($fp);

    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."test.png";

    // post to arena
    include '../../../arena.php';
    $arena = new Arena();

    $block = $arena->create_block($slug, array('source' => $url));
    $arena->select_block($block->connection_id);
  }
?>
