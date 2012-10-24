<?php 
include 'arena.php';
$arena = new Arena();
$channel = $arena->get_channel('interesting-menu');
$channel->each_channel_item(array('sort' => 'desc'), function($item) {
?>

  <div id="<?= $item['base_class'] ?> <?= $item['class'] ?>">
    <?= $item['content_html'] ?>
  </div>

<?php 
});
?>
