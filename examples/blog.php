<?php
/*
 * Arena Blog Example 
 */

# include the are.na api library 
include '../arena.php';

$arena = new Arena();
$channel = $arena->get_channel('blog-are-na');
$channel->set_sort_order('asc');
?>

<html>

    <head>
        <title><?= $channel->title; ?></title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="examples.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="blog">
            <div id="blog-title">
                <a href = "blog.php"><?= $channel->title; ?></a>
            </div>
            <div id="blog-content">
                <?php $channel->each_item(function($item) {?>
                    <div class="blog-post"> 
                        <div class="blog-post-title">
                            <a href="<?= $item->id ?>"><?= $item->title ?></a>
                        </div>

                        <div class="blog-post-meta">
                            By <?= $item->user['username'];?> <?= $item->relative_time() ?>
                        </div>

                        <div class="blog-post-content">
                            
                            <?php if($item->is_image()) { ?>
                            <div class="blog-post-entry-content">
                                <a href="<?= $item->image_url('original') ?>">
                                    <img src="<?= $item->image_url('display') ?>" />
                                </a>
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
                
                            <?php if($item->is_link()){ ?>
                                <div class="blog-post-entry-content">
                                    <a href="<?= $item->source['url'] ?>">
                                        <img src="<?= $item->image_url('display') ?>">
                                    </a>
                                    <br />
                                    <a href="<?= $item->source['url'] ?>">
                                        <?= $item->generated_title ?>
                                    </a>
                                </div>
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
                        
                        </div>	
                    
                </div>
            </div>  
        <?php }); ?>
        </div>

    </body>
</html>
