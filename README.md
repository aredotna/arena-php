# Arena PHP Library

## Contents

* [Setup](#setup)
* [Channel](#channel)
* [Block](#block)
* [User](#user)

## Setup

Include the Arena class:
```
include '../../arena.php';
```

and set a new instance:
```
$arena = new Arena();
```

*Optional*: To authenticate your application (with your personal access token), open config.php (in the /lib folder) and set your auth token:
```
$config['access_token'] = 'YOUR AUTH TOKEN HERE'
```
Your auth_token can be retrieved from http://dev.are.na .

## Channel

Channels are containers for blocks (and sometimes other channels) with permissions meta information. Channels retrieved with this library all come in the form of objects, and their attributes accessible in the form of $this->attribute, (e.g. $channel->title). 

### Retrieving a channel:

```
$channel = $arena->get_channel($slug, array('page' => $page, 'per' => $per));
```

The Channel class can (and should) be extended to serve particular needs and goals, but there are a few convience methods included in this extremely early version of the library.

### Sorting a channel's contents
At the moment, there is no API support for retrieving contents in a specific order, so for now we can sort the channel's contents after the fact (please keep in mind that if you are paginating, you are only going to be sorting the sum of what you retrieved).

Options for sorting: 
+ 'asc' (ascending by date)
+ 'desc', (descending by date)
+ 'position' (sorted by user determined position in the channel, this is default)

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
<?php $arena->get_block($id) ?>
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
