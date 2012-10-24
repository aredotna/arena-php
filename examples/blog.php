<?php
/*
 * Arena Blog Example 
 */

# include the are.na api library 
include('../arena.php');

# set the post limit
# Null returns all posts
$per = 3;

#pagination
if (isset($_GET['page'])){
    $page = $_GET['page'];
} else {
    $page = 1;
}

# use this to set the next page number at the bottom page link
$next_page = $page + 1;

# create an arena connection and call for the posts
$arena = new ArenaAPi();

# make a call to the arena api to get the data
$channel = $arena->get_channel('arena-influences');

# seperate the blocks from the channel
$channel_blocks = $arena->get_channel_blocks($channel);

# use filtering method to separate out blog metadata
$blog_meta = $arena->get_channel_meta($channel);

# get sorted blocks to use as content
$blog_content = $arena->sort_blocks_by_created($channel_blocks);

?>

<html>

    <head>
        <title><?php echo ($blog_meta['title']); ?>: A Blog</title>
        <meta charset='utf-8' />
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' />
        <link href="examples.css" media="screen" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <div id="blog">
            <div id="blog-title">
                <a href = "blog.php">
                    <?php echo ($blog_meta['title']); ?>
                </a>
            </div>
            <div id="blog-content">
                <?php __::each($blog_content, function($content) { ?>
                    <div class="blog-post"> 
                        <div class="blog-post-title">
                            <a href="<?php echo($content['source_url']); ?>"><?php echo($content['title']); ?></a>
                        </div>

                        <div class="blog-post-meta">
                            By <?php echo($content['username']); ?> on <?php echo($content['readable_updated_at']); ?>
                        </div>

                        <div class="blog-post-content">
                            
                            <?php if ($content['block_class'] == 'image'){ ?>
                            <div class="blog-post-entry-content">
                                <a href="<?php echo($content['image_original']) ?>">
                                    <img src="<?php echo($content['image_display']) ?>" />
                                </a>
                            </div>
                            <div class="blog-post-description">
                                <?php echo($content['description']); ?>
                            </div>
                            <?php } ?>
                
                            <?php if ($content['block_class'] == 'media'){ ?>
                                <div class="blog-post-entry-content">
                                    <?php echo($content['embed_html']) ?>
                                </div>
                                <div class="blog-post-description">
                                    <?php echo($content['description']); ?>
                                </div>
                            <?php } ?>
                
                            <?php if ($content['block_class'] == 'link'){ ?>
                                <div class="blog-post-entry-content">
                                    <a href="<?php echo($content['source_url']) ?>">
                                        <img src="<?php echo($content['image_display']) ?>">
                                    </a>
                                    <br />
                                    <a href="<?php echo($content['source_url']) ?>">
                                        <?php echo($content['source_url']) ?>
                                    </a>
                                </div>
                                <div class="blog-post-description">
                                    <?php echo($content['description']); ?>
                                </div>	
                            <?php } ?>
                
                            <?php if ($content['block_class'] == 'text'){ ?>
                                <div class="blog-post-entry-content">
                                    <p><?php echo($content['content']) ?></p>
                                </div>
                                <div class="blog-post-description">
                                    <?php echo($content['description']); ?>
                                </div>
                            <?php } ?>
                        
                        </div>	
                    
                        <?php if (!empty($content['connections'])) { ?>
                            <div class="blog-post-connections">
                            <?php __::each($content['connections'], function($connection) { 
                            global $content; //bring content var into this function's scope 
                            ?>
                            <div class="connection">
                                + This <?php echo($connection['connectable_type']);?> is also featured in: 
                                    <?php if( $connection['channel']['title'] != $content['channel']['title'] ) { ?>
                                        <a target="_blank" href="http://are.na/#<?php echo($connection['channel']['slug']); ?>">
                                            <?php echo($connection['channel']['title']); ?>
                                        </a>
                                    <?php } ?>
                            </div>
                            <?php }); ?>
                       <?php } ?>
                </div>
            </div>  
        <?php }); ?>
        </div>

        <!--
        <div id="blog-navigation">
            <?php if (isset($next_page)){ ?>
                <a href = "?page=<?php echo($next_page) ?>">Next >></a>
            <?php } else { ?>
                <a href = "blog.php">Home</a>
            <?php } ?>
        </div>
        -->
    </body>
</html>
