<?php 
include '../arena.php';
$arena = new Arena();
?>

<?php $channel->each_item(function($item) {?>

  <div id="<?= $item->css_class(); ?> <?= $item->base_css_class();?>">
    <?= strtotime($item->connected_at) ?>
  </div>

<?php }); ?>
