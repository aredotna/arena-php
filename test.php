<?php 
include 'arena.php';
$arena = new Arena();
$channel = $arena->get_channel('interesting-menu', array('page' => 1, 'per' => 1));
$arena->loop_channel_contents($channel, array('sort' => 'desc'), function($item) {
?>

  <div id="<?= $item['base_class'] ?> <?= $item['class'] ?>">
    <?= $item['content_html'] ?>
  </div>

<?php 
});
?>
