<?php 
include 'arena.php';
$arena = new Arena();
$channel = $arena->get_channel('interesting-menu');
$arena->loop_channel_contents($channel, array('sort' => 'desc'), function($block) {
?>

  <div id="block <?= $block['class'] ?>">
    <?= $block['content_html'] ?>
  </div>

<?php 
});
?>
