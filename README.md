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

## Channel

Retrieving a channel:

```
$channel = $arena->get_channel($slug, array('page' => $page, 'per' => $per));
```

## Block

## User
