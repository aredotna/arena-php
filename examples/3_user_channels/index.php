<?php 

/*
 * Arena User Channel List Example
 * 
 * 
 */

include '../../arena.php';

$arena = new Arena();
$user_slug = 'dena-yago'; // user slug (e.g. http://are.na/dena-yago)

$user = $arena->get_user($user_slug);
$channels = $arena->get_user_channels($user_slug);

?>

<!DOCTYPE html>
<html>
  <head>
    <title><?= $user->username; ?>'s Channels</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <style type="text/css">
      .loading{background-color: #eee; opacity: 0.4;}
      #content.loading{text-indent: 100%;overflow: hidden;}
      #content{min-height: 100%;}
    </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <ul class="nav nav-tabs nav-stacked">
            <li><h4><?= $user->username; ?>'s Channels</h4></li>
            <?php $channels->each_channel(function($channel) {?>
              <li><a class="channel" href="view.php?id=<?= $channel->slug ?>"><?= $channel->title ?></a></li>
            <?php }); ?>
          </ul>
        </div>
        <div id="content" class="span10">
          <!--Body content-->
        </div>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
      $('a.channel').on('click', function(e){
        e.preventDefault();
        $("#content").addClass('loading');
        $.get(e.target.href, function(data){
          $("#content").html(data);
          $("#content").removeClass('loading');
          window.scrollTo(0,0);
        })
      })
    </script>
  </body>
</html>