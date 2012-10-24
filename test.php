<?php 
include 'arena.php';
$arena = new Arena();
$channel = $arena->get_channel('interesting-menu');
$channel->each_channel_item(function($item) {
?>

  <div id="<?= $item['base_class'] ?> <?= $item['class'] ?>">
    <?= strtotime($item['connected_at']) ?>
  </div>

<?php 
});
?>
