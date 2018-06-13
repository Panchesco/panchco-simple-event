# Simple Event

A WordPress Plugin for assigning date & time values to post types.

## Installation

Clone or download the repo to the WordPress plugins directory.

## Settings

Select the post types you want to associate with the Simple Event date and time options.

## Template Functions

### ```se_event_start($post_id, $format)```

Display the event start date & time value.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |



### ```se_event_end($post_id, $format)```

Display the event end date & time value.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```se_event_archive($post_id, $format)```

Display the event archive date & time value.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |

### ```se_all_day($post_id)```

Displays Yes or No if an event is All Day 

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |


### ```get_se_event_start($post_id, $format)```

Returns the event start date & time value. Returns false if no value exists.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```get_se_event_end($post_id, $format)```

Returns the event end date & time value. Returns false if no value exists.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```get_se_event_archive($post_id, $format)```

Returns the event end archive & time value. Returns false if no value exists.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | l, F j, Y |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |

### ```get_se_all_day($post_id)```

Returns Yes or No if the event is All day or not.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |


### ```se_posts($config)```

Returns the results of a WP_Query() instance queried against saved Simple Event date & time values.
In addition to parameters available in the [WP_Query()](https://codex.wordpress.org/Class_Reference/WP_Query#Parameters), the following parameters are available:

| Argument array element | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```post_type``` | Yes |	post_type slug | None | string,array |
| ```orderby``` | No |	Post element to orderby | string,array start_date | start_date, end_date, archive_date, title |
| ```order``` | No |	Order results in ascending or descending order | string,array DESC | ASC, DESC |
| ```all_day``` | No |	Include all day events in results? | Yes | Yes, No, Only |
| ```show_archived``` | No |	Include events whose archive date has passed in results? | Yes | Yes, No |


































