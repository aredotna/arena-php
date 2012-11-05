<?php 

/*
 * Arena Document Example / Permalink
 * 
 * 
 */

include '../../arena.php';

$arena = new Arena();

$item = $arena->get_block($_GET['id']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $channel->title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="http://www.w3.org/StyleSheets/Core/Modernist" type="text/css">
    <style type="text/css">
      img, iframe{padding-left: 11%;}
      p, p:first-child{padding-right: 11%}
      div > p:first-child, body > p:first-child, td > p:first-child{padding-right: 11%}
      a.img{background-color: #fff;}
    </style>
  </head>
  <body>

    <div id="contents">
      <div class="item <?= $item->css_class()?>">
        <h3><?= $item->generated_title ?></h3>
        <div class="blog-content">
          
          <?php if($item->is_image()) { ?>
            <a class='img' href="<?= $item->image_url('original') ?>">
              <img src="<?= $item->image_url('display') ?>" />
            </a>
            <div class="blog-post-description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>

          <?php if($item->is_link()){ ?>
            <a class='img' href="<?= $item->source['url'] ?>">
              <img src="<?= $item->image_url('display') ?>">
            </a>
            <div class="blog-post-description">
              <?= $item->description_html ?>
            </div>  
          <?php } ?>

          <?php if($item->is_text()){ ?>
            <div class="blog-post-entry-content">
              <p><?= $item->content_html ?></p>
            </div>
            <div class="blog-post-description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>

          <?php if($item->is_embed()){ ?>
            <div class="blog-post-entry-content">
              <?= $item->embed['html'] ?>
            </div>
            <div class="blog-post-description">
              <?= $item->description_html ?>
            </div>
          <?php } ?>


          <?php if($item->is_attachment()){ ?>
            <p><?= $item->attachment['file_name'] ?> <a href="<?= $item->attachment['url'] ?>">(download)</a></p>
          <?php } ?>
        </div>
        <h3><a href="index.php">Back</a></h3>
      </div>
    </div>
  </body>
</html>