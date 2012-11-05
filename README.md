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
$config['auth_token'] = 'YOUR AUTH TOKEN HERE'
```
Your auth_token can be retrieved from http://dev.are.na .

## Channel

Channels are containers for blocks (and sometimes other channels) with permissions meta information. Channels retrieved with this library all come in the form of objects, and their attributes accessible in the form of $this->attribute, (e.g. $channel->title). 

### Retrieving a channel:

```
$channel = $arena->get_channel($slug, array('page' => $page, 'per' => $per));
```

The Channel class can (and should) be extended to serve particular needs and goals, but there are a few convience methods included in this extremely early version of the library.

#### Sorting a channel's contents
At the moment, there is no API support for retrieving contents in a specific order, so for now we can sort the channel's contents after the fact (please keep in mind that if you are paginating, you are only going to be sorting the sum of what you retrieved).

Options for sorting: 
*'asc' (ascending by date)
*'desc', (descending by date)
*'position' (sorted by user determined position in the channel, this is default)

```
<?php $channel->set_sort_order($direction) ?>
```

#### Printing a list of authors (main author and all collaborators)
```
<?= $channel->authors_to_sentence(); ?>
```
Example output: 'Charles Broskoski, John Michael Boling, Dena Yago, Damon Zucconi, J. Stuart Moore, and Emily Segal'

#### Looping through channel contents (blocks and channels)

For the sake of simplicity, contents in a channel are all set to class 'Block'. The contents can be looped through using the each_item() method like so:
```
<?php $channel->each_item(function($item) {?>
  // Item templates go here
<?php } ?>
```

## Block



## User
