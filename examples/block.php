<?php

# include the are.na api library 
include('../arena.php');

#pass block id either by get variable or hardcoded
if (isset($_GET['block'])){
    $block_id = $_GET['block'];
} else {
    $block_id = 635;
}

# create a new arena connection object 
# and get the specified block
$arena = new ArenaAPi();
$block = $arena->get_block($block_id);

# what content type is the block
$block_class = $arena->get_block_class($block);
$connections = $arena->get_connections_for_block($block);

?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <!-- doc title set in js -->
    <title><?php echo($main_channel['user']['username']); ?></title>

    <!-- set client description in content here-->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link href="examples.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="wrapper">

        <div id="blocks">	
                <div id="block">
                    <div id='block-title'></div>            
                    
                    <?php if ($block_class == 'image'){ ?>
                        <div class="entry image">		
                            <div class="entry-title" >
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <a href="<?php echo($block['image_original']) ?>">
                                    <img src="<?php echo($block['image_display']) ?>">
                                </a>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>
                    <?php } ?>
                
                    <?php if ($block_class == 'media'){ ?>
                        <div class="entry media">		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <?php echo($block['embed_html']) ?>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>	
                    <?php } ?>
                
                    <?php if ($block_class == 'link'){ ?>
                        <div class="entry link">		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <a href="<?php echo($block['source_url']) ?>">
                                    <img src="<?php echo($block['image_display']) ?>">
                                </a>
                                <br />
                                <a href="<?php echo($block['source_url']) ?>">
                                    <?php echo($block['source_url']) ?>
                                </a>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>	
                    <?php } ?>
                
                    <?php if ($block_class == 'text'){ ?>
                        <div class="entry text" >		
                            <div class="entry-title">
                                <h2> <?php echo($block['title']) ?> </h2>
                            </div>	
                            <div class="entry-content">
                                <p><?php echo($block['content']) ?></p>
                            </div>
                            <div class="entry-description">
                                <?php echo($block['description']) ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>	
        </div>            
    	
        <div id="connections">
            <h2>Connections</h2>
            <ul>
            <?php if(isset($connections)){
                 __::each($connections, function($connection) { ?>
                <li class="connection" >		
                    <a target="_blank" href="http://are.na/#/<?php echo($connection['channel']['slug']) ?>" id="connection-box"><?php echo($connection['channel']['title']) ?></a>
                </li>
                <?php });
            } ?>
            </ul>
    	</div>


    </div><!-- end wrapper div-->

</body>
    
</html>
