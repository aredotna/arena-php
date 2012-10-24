<?php

# include the are.na api library 
include('../arena.php');

# create a new arena connection object
$arena = new ArenaAPi();

#get the channel you want to show
$page_channel = $arena->get_channel('arena-influences');

$nav_items = $arena->get_channel_content($page_channel);

if (isset($_GET['block'])){
    $requested_item = $_GET['block'];
    $current_item = $arena->get_block($requested_item);
    $blocks = array($current_item);
    $connections = $arena->get_connections_for_block($current_item);
}

if (isset($_GET['channel'])){
    $requested_item = $_GET['channel'];
    $current_item = $arena->get_channel($requested_item);
    $connections = $arena->get_channel_connections($current_item);
    $blocks =  $arena->get_channel_blocks($current_item);
}

if (!isset($requested_item)) {
    // if nothing requested, get first item
    $current_item = array_shift(array_values($nav_items));
    $blocks = array($current_item);
    $connections = $arena->get_connections_for_block($current_item);
}

//pretty_print_array($blocks);

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
    <title><?php echo($page_channel['title']);  ?></title>

    <!-- set client description in content here-->
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
    <link href="examples.css" media="screen" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="wrapper">

        <div id="nav" class="scroll-pane">		
            <div id="nav-header">
                <a href="/"><?php echo($page_channel['title']); ?></a>
            </div>
            <div id="navigation">
                <ul>
                <?php __::each($nav_items, function($item) { ?>
                    <?php if($item['type'] == 'Block'){ ?>
                        <li>
                            <a href="?block=<?php echo($item['id']); ?>" class="results"><?php echo($item['title']); ?></a>
                        </li>
                    <?php } ?>
                    <?php if($item['type'] == 'Channel'){ ?>
                        <li>
                            <a href="?channel=<?php echo($item['id']); ?>" class="results"><?php echo($item['title']); ?></a>
                        </li>
                    <?php } ?>

                <?php }); ?>
                </ul>	
            </div>		
        </div>

        <div id="blocks">	
            <?php __::each($blocks, function($block) { ?>
                <div id="block"> 
                    <?php if ($block['block_class'] == 'image'){ ?>
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
                
                    <?php if ($block['block_class'] == 'media'){ ?>
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
                
                    <?php if ($block['block_class'] == 'link'){ ?>
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
                
                    <?php if ($block['block_class'] == 'text'){ ?>
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
            <?php }); ?>
        </div>            
    	
        <div id="connections">
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


