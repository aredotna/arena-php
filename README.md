# Arena PHP
![COOL PHP](http://s3.amazonaws.com/arena_images/51397/original_9a676dd6d3b2e273028dc58cb8dcd7e2.png)
## Contents

* [Setup](#setup)
* [Channel](#channel)
* [Block](#block)
* [User](#user)
* [Resources](#resources)
* [Contribute](#contribute)
* [Acknowledgements](#acknowledgements)

## Setup

Include the Arena class:
```
include 'arena.php';
```

Or install with [Composer](https://getcomposer.org/) and require the autoload:
```
require 'vendor/autoload.php';
```

Then set a new instance:
```
$arena = new Arena();
```

*Optional*: To authenticate your application (with your personal access token), open config.php (in the /lib folder) and set your auth token:
```
$config['access_token'] = 'YOUR AUTH TOKEN HERE'
```
Your access token can be retrieved from http://dev.are.na .

## Channel

Channels are organizational structures for blocks (and sometimes other channels) with permissions and other meta information. Channels retrieved with this library all come in the form of objects, and their attributes accessible in the form of $this->attribute, (e.g. $channel->title). 

### Retrieving a channel:

```
<?php $channel = $arena->get_channel($slug, array('page' => $page, 'per' => $per)); ?>
```
returns:

```
{
id: 1546,
title: "blog.are.na",
created_at: "2012-03-12T15:13:27Z",
updated_at: "2012-11-03T22:28:25Z",
published: true,
open: false,
collaboration: true,
slug: "blog-are-na",
length: 45,
kind: "default",
status: "closed",
user_id: 15,
contents_updated_at: "2012-10-23T16:30:50Z",
class: "Channel",
base_class: "Channel",
user: {
  id: 15,
  slug: "charles-broskoski",
  username: "Charles Broskoski",
  first_name: "Charles",
  last_name: "Broskoski",
  full_name: "Charles Broskoski",
  avatar: "http://gravatar.com/avatar/c6ea2918c7da408451f528255632b58d.png?s=40&d=mm&r=R&d=http://s3.amazonaws.com/arena_assets/assets/interface/missing.png",
  email: "broskoski@gmail.com",
  channel_count: 75,
  following_count: 419,
  profile_id: 111,
  follower_count: 157,
  class: "User",
  initials: "CB"
},
total_pages: 1,
current_page: 1,
per: 1000,
follower_count: 7,
contents: [
  ....
],
collaborators: [
  {
    id: 17,
    slug: "damon-zucconi",
    username: "Damon Zucconi",
    first_name: "Damon",
    last_name: "Zucconi",
    full_name: "Damon Zucconi",
    avatar: "http://gravatar.com/avatar/649c4301c6c5c9605fbf87e003427767.png?s=40&d=mm&r=R&d=http://s3.amazonaws.com/arena_assets/assets/interface/missing.png",
    email: "mail@damonzucconi.com",
    channel_count: 117,
    following_count: 283,
    profile_id: 105,
    follower_count: 148,
    class: "User",
    initials: "DZ"
  }
]
}
```

The Channel class can (and should) be extended to serve particular needs and goals, but there are a few convience methods included in this extremely early version of the library.

### Sorting a channel's contents
At the moment, there is no API support for retrieving contents in a specific order, so for now we can sort the channel's contents after the fact (please keep in mind that if you are paginating, you are only going to be sorting the sum of what you retrieved).

Options for sorting: 
+ *asc* (ascending by date)
+ *desc* (descending by date)
+ *position* (sorted by user determined position in the channel, this is default)

```
<?php $channel->set_sort_order($direction) ?>
```

### Printing a list of authors (main author and all collaborators)
```
<?= $channel->authors_to_sentence(); ?>
```
Example output: 'Charles Broskoski, John Michael Boling, Dena Yago, Damon Zucconi, J. Stuart Moore, and Emily Segal'

### Looping through channel contents (blocks and channels)

For the sake of simplicity, contents in a channel are all set to class 'Block'. The contents can be looped through using the each_item() method like so:
```
<?php $channel->each_item(function($item) {?>
  // Item templates go here
<?php } ?>
```

## Block

For now block methods are mostly for template simplicity, this class should also be extended to accomplish specific goals.

### Block classes

To check the specific type of block in an item loop (or otherwise) use these methods (is_image(), is_text(), is_embed(), is_link(), is_attachment(), is_channel()) like so:

```
<?php $channel->each_item(function($item) {?>
  <?php if($item->is_image()) { ?>
    <a class='img' href="<?= $item->image_url('original') ?>">
      <img src="<?= $item->image_url('display') ?>" />
    </a>
  <?php } ?>
<?php } ?>
```

### Retrieving a specific Block

You can also retrieve specific blocks from the API. This can be used to handle permalinking of specific content.

```
<?php $arena->get_block($id) ?> # $id = 1000
```
returns:
```
{
id: 1000,
title: "caveman time + globalization",
updated_at: "2011-12-13T23:42:51Z",
created_at: "2011-08-13T00:22:29Z",
state: "available",
comment_count: 0,
generated_title: "caveman time + globalization",
class: "Image",
base_class: "Block",
content: "caveman time and globalization",
content_html: "<p>caveman time and globalization</p> ",
description: "caveman time and globalization",
description_html: "<p>caveman time and globalization</p> ",
image: {
  filename: "mcd-billboard.gif",
  content_type: "image/gif",
  updated_at: "2011-08-13T00:22:28Z",
  thumb: {
    url: "http://s3.amazonaws.com/arena_images/1000/thumb_mcd-billboard.gif"
  },
  display: {
    url: "http://s3.amazonaws.com/arena_images/1000/display_mcd-billboard.gif"
  },
  original: {
    url: "http://s3.amazonaws.com/arena_images/1000/original_mcd-billboard.gif",
    file_size: 48328,
    file_size_display: "47.2 KB"
  }
},
user: {
  id: 53,
  slug: "sun-an",
  username: "sun an",
  first_name: "sun",
  last_name: "an",
  full_name: "sun an",
  avatar: "http://gravatar.com/avatar/5dc858da6a9f2c8f20757e36119ef827.png?s=40&d=mm&r=R&d=http://s3.amazonaws.com/arena_assets/assets/interface/missing.png",
  email: "mail@sun-an.com",
  channel_count: 8,
  following_count: 5,
  profile_id: 298,
  follower_count: 15,
  class: "User",
  initials: "sa"
},
connections: [
  {
    id: 298,
    title: "sun an",
    created_at: "2011-08-13T00:17:45Z",
    updated_at: "2012-01-11T21:22:30Z",
    published: true,
    open: true,
    collaboration: false,
    slug: "sun-an",
    length: 3,
    kind: "profile",
    status: "public",
    user_id: 53,
    contents_updated_at: "2012-01-11T21:22:30Z",
    class: "Channel",
    base_class: "Channel"
  },
  {
    id: 208,
    title: "Gideon Yago",
    created_at: "2011-08-03T19:14:00Z",
    updated_at: "2012-01-11T21:22:29Z",
    published: true,
    open: true,
    collaboration: false,
    slug: "gideon-yago",
    length: 1,
    kind: "profile",
    status: "public",
    user_id: 29,
    contents_updated_at: "2012-01-11T21:22:29Z",
    class: "Channel",
    base_class: "Channel"
  }
]
}
```

### Creating a new block

You can do basic POST operations with this library to create new Blocks for channels. 

Note: To accomplish this you **must** provide an access token to authenticate the POST request.
```
<?php 
  $channel_slug = 'my-special-channel';
  $block_attrs = array('source' => 'http://imgs.xkcd.com/comics/poll_watching.png');
  $arena->create_block($channel_slug, $block_attrs);
?>
```


## User

### Retrieving a specific user's info

```
<?php $arena->get_user($user_slug) ?> # $user_slug = 'charles-broskoski' 
```

returns: 

```
{
id: 15,
slug: "charles-broskoski",
username: "Charles Broskoski",
first_name: "Charles",
last_name: "Broskoski",
full_name: "Charles Broskoski",
avatar: "http://gravatar.com/avatar/c6ea2918c7da408451f528255632b58d.png?s=40&d=mm&r=R&d=http://s3.amazonaws.com/arena_assets/assets/interface/missing.png",
email: "broskoski@gmail.com",
channel_count: 76,
following_count: 420,
profile_id: 111,
follower_count: 157,
class: "User",
initials: "CB"
}
```

### Retrieving a user's channel list

```
<?php $arena->get_user_channels($user_slug)?>
```

This returns an object that contains an array of Channel objects (note: these channels do not have block content included in them, only base representations of the channels are returned).

## Resources
  
  + [Examples](https://github.com/arenahq/arena-php/tree/master/examples)
  + [dev.are.na](http://dev.are.na)

## Contribute

  Please fork and contribute! Also let us know if you are using the library on your site!

  [arena@are.na](mailto:arena@are.na)

## Acknowledgements

  This project includes the wonderful [Underscore.php](http://brianhaveri.github.com/Underscore.php/) without which I would have never agreed to do this.
