<?php 

/*
 * Arena channel-in-channel example: view
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
    <link rel="stylesheet" href="http://www.w3.org/StyleSheets/Core/Modernist" type="text/css">
    <style type="text/css">
      img, iframe{padding-left: 11%;}
      p, p:first-child{padding-right: 11%}
      div > p:first-child, body > p:first-child, td > p:first-child{padding-right: 11%}
      a.img{background-color: #fff;}
      #contents h3 a{
        color:#000;
        background-color: #ccc;
      }
      #contents h3 a:hover{
        text-decoration: underline;
      }
    </style>
  </head>
  <body>
    
    <div id="header">
      <h1><?= $channel->title; ?></h1>
      <p>
        <i>by <?= $channel->authors_to_sentence(); ?></i><br>
      </p>
      <h2><a href="index.php">Back</a></h2>
    </div>

    <div id="contents">

      <!-- start looping through channel items and provide each type of block -->
      <!-- (image, embed, link, text, attachment, channel) with a template -->

      <?php $channel->each_item(function($item) {?>

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

            <?php if($item->is_channel()){ ?>

              <h3><a href="view.php?id=<?= $item->slug ?> "><?= $item->title ?></a></h3>
            <?php } ?>


          </div>
        </div>

      <?php }); ?>

      <!-- end channel loop -->

    </div>
  </body>
</html>