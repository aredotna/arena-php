<?php 

/*
 * Arena ajax loaded contents of a channel
 * 
 * 
 */

include '../../arena.php';

$arena = new Arena();
$slug = $_GET['id']; // channel slug (passed in from url param)
$channel = $arena->get_channel($slug);
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $channel->title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  </head>
  <body>
    <?php $channel->each_item(function($item) {?>

      <div class="item <?= $item->css_class()?>">
        <h3><?= $item->generated_title ?></h3>
        <div class="content">
          
          <?php if($item->is_image()) { ?>
            <a class='img' href="<?= $item->image_url('original') ?>">
              <img src="<?= $item->image_url('display') ?>" />
            </a>
            <div class="description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>

          <?php if($item->is_link()){ ?>
            <a class='img' href="<?= $item->source['url'] ?>">
              <img src="<?= $item->image_url('display') ?>">
            </a>
            <div class="description">
              <?= $item->description_html ?>
            </div>  
          <?php } ?>

          <?php if($item->is_text()){ ?>
            <div class="entry-content">
              <p><?= $item->content_html ?></p>
            </div>
            <div class="description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>

          <?php if($item->is_embed()){ ?>
            <div class="entry-content">
              <?= $item->embed['html'] ?>
            </div>
            <div class="description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>


          <?php if($item->is_attachment()){ ?>
            <p><?= $item->attachment['file_name'] ?> <a href="<?= $item->attachment['url'] ?>">(download)</a></p>
          <?php } ?>

        </div>
      </div>

    <?php }); ?>
  </body>
</html>