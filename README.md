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
