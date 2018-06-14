# Simple Event

A WordPress Plugin for assigning an event start date, end date, and archive information to posts.

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
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |



### ```se_event_end($post_id, $format)```

Display the event end date & time value.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```se_event_archive($post_id, $format)```

Display the event archive date & time value.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |

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
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```get_se_event_end($post_id, $format)```

Returns the event end date & time value. Returns false if no value exists.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |


### ```get_se_event_archive($post_id, $format)```

Returns the event end archive & time value. Returns false if no value exists.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |
| ```$format``` | No |	PHP date format string | See notes below |  See [PHP docs for date strings](http://php.net/manual/en/function.date.php) |

### ```get_se_all_day($post_id)```

Returns Yes or No if the event is All day or not.

#### Parameters

| Parameter | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```$post_id``` | Yes |	Post ID | None |  |


### ```se_posts( $args )```

Returns the results of a WP_Query() instance queried against saved Simple Event date & time values.
In addition to parameters available in the [WP_Query()](https://codex.wordpress.org/Class_Reference/WP_Query#Parameters), the following parameters are available:

| Argument array element | Required? |	Description | Default | Options |
| --- | --- | --- | --- | --- |
| ```post_type``` | Yes |	post_type slug | None | string,array |
| ```orderby``` | No |	Post element to orderby | string,array start_date | start_date, end_date, archive_date, title |
| ```order``` | No |	Order results in ascending or descending order | string,array DESC | ASC, DESC |
| ```all_day``` | No |	Include all day events in results? | Yes | Yes, No, Only |
| ```show_archived``` | No |	Include events whose archive date has passed in results? | Yes | Yes, No |

## Example

Using se_posts() function with the loop to display all events that are happening today. Do not show events whose archive date has passed.

```
<?php 
  
  
  // Create an array of arguments with parameters for this plugin.
  
  $args = array();
  $args['post_type'] = array('post_type');
  $args['orderby'] = 'start_date';
  $args['show_archived'] = 'no';
  
  
  // Add some WP_Query() arguments
  
  $args['order'] = 'DESC';
  $args['category_name'] = 'category-slug';
  
  
  // Use WP current_time() function to set current time as Y-m-d H:i
     
  $now = current_time('Y-m-d H:i');


  // Add a date range as you would with a call to WP_Query().
  
  $args['meta_query'][] = array(
                              array('key' => 'panchco_start_date',
                                    'value' => $now,
                                    'compare' => '<=',
                                    'type' => 'DATETIME'),
                              'relation' => 'AND',   
                              array('key' => 'panchco_end_date',
                                    'value' => $now,
                                    'compare' => '>=',
                                    'type' => 'DATETIME')
                                    
                            );
                                               

// Pass the args to se_posts() function as you would a WP_Query() and use the query in a WP loop.

$query = se_posts($args);

?>

<?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>
<article>
<?php if( get_se_all_day( get_the_id() ) == "Yes") { ?>
<?php se_event_start(get_the_id(), 'l, F j, Y');?> &ndash; <?php se_event_end(get_the_id(), 'l, F j, Y');?>
<?php } else { ?> 
<time datetime="<?php se_event_start(get_the_id(),'c');?>"><?php se_event_start(get_the_id());?></time>
<?php } ?>
  <h1><?php the_title() ;?></h1>
  <?php the_content() ;?>
  <p>Published on: <?php the_date();?></p>
</article>
<hr>
<?php endwhile; endif; ?>

```

## Option Names & Types for Custom Queries


| Option Name | Description | Type |
| --- | --- | --- |
| ```panchco_start_date``` | Saved event start date | DATETIME |
| ```panchco_end_date``` | Saved event end date | DATETIME |
| ```panchco_archive_date```| Saved archive date | DATETIME |
| ```panchco_all_day``` | Saved all day checkbox value | CHAR |

## Notes

* Date Format string defaults to current WP installation in Settings > General.
* Time Format strings defaults to current WP installation in Settings > General.





































