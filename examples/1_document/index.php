<?php 

/*
 * Arena Document Example (with pagination)
 * 
 * 
 */

# include the are.na api library 
include '../../arena.php';

$arena = new Arena();
$page = $arena->set_page();
$per = 5;
$channel = $arena->get_channel('loose-connections', array('page' => $page, 'per' => $per));
?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $channel->title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="http://www.w3.org/StyleSheets/Core/Modernist" type="text/css">
    <style type="text/css">
      img, iframe{padding-left: 11%;}
      a.img{background-color: #fff;}
    </style>
  </head>
  <body>
    
    <div id="header">
      <h1><?= $channel->title; ?></h1>
      <p>
        <i>by <?= $channel->authors_to_sentence(); ?></i><br>
        <i>Last Updated: <?= date('D, d M Y H:i:s', strtotime($channel->updated_at)); ?></i>
        <div class="pages">    
          <p>
            <?php if($channel->total_pages > 1){ ?><b>Pages: </b><? } ?>
            <?php $channel->each_page($page, function($num, $current_page){ ?>
              <?php if($num == $current_page){ ?>
                <?= $num ?>
              <?php }else{ ?>
                <a href="?page=<?= $num ?>"><?= $num ?></a>
              <?php } ?>
            <?php }); ?>
          </p>
        </div>
      </p>
    </div>

    <div id="contents">

      <!-- start looping through channel items -->

      <?php $channel->each_item(function($item) {?>

        <div class="item <?= $item->css_class()?>">
          <h2><?= $item->generated_title ?></h2>
          <div class="blog-content">
            
            <?php if($item->is_image()) { ?>
              <a class='img' href="<?= $item->image_url('original') ?>">
                <img src="<?= $item->image_url('display') ?>" />
              </a>
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
              <h5><a href="/permalink.php?id=<?= $item->id ?>"><?= $item->title ?></a></h5>

              <div class="blog-post-entry-content">
                <p><?= $item->content_html ?></p>
              </div>
              <div class="blog-post-description">
                <?= $item->description_html ?>
              </div>
            <?php } ?>

            <?php if($item->is_embed()){ ?>
              <h5><a href="/permalink.php?id=<?= $item->id ?>"><?= $item->title ?></a></h5>

              <div class="blog-post-entry-content">
                <?= $item->embed['html'] ?>
              </div>
              <div class="blog-post-description">
                <?= $item->description_html ?>
              </div>
            <?php } ?>


          </div>
        </div>

      <?php }); ?>

      <!-- end channel loop -->

      <p class="ltb"></p>

      <div class="pages">
          <p>
            <?php  if($channel->total_pages > 1){ ?><b>Pages: </b><? } ?>
            <?php $channel->each_page($page, function($num, $current_page){ ?>
              <?php if($num == $current_page){ ?>
                <?= $num ?>
              <?php }else{ ?>
                <a href="?page=<?= $num ?>"><?= $num ?></a>
              <?php } ?>
            <?php }); ?>
          </p>
      </div>

    </div>
  </body>
</html>