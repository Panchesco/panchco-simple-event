<?php
/*
Plugin Name: Simple Event
Plugin URI: https://github.com/Panchesco/panchco-simple-event
Description: Adds an event date time
Author: Richard Whitmer
Version: 1.1.0
*/


 function panchco_simple_event_metabox() {
  
    $post_types = get_option('panchco_simple_event_post_types');
    
    if( $post_types && ! empty($post_types)) {
    add_meta_box( 
        'panchco_simple_event_metabox', 
        __( 'Event Info', 'panchco'), 
        'panchco_simple_event_metabox_callback', 
        $post_types, 
        'side', 
        'low'
        );
    }
}

add_action( 'add_meta_boxes', 'panchco_simple_event_metabox' );

//-----------------------------------------------------------------------------

/**
 * Display the metabox.
 */
function panchco_simple_event_metabox_callback( $post ) { ?>
     
    <form action="" method="post">
        <?php        
        //retrieve metadata value if it exists
        $panchco_event_date = get_post_meta( $post->ID, 'panchco_event_date', true );
        $panchco_end_date = get_post_meta( $post->ID, 'panchco_end_date', true );
        $panchco_archive_date = get_post_meta( $post->ID, 'panchco_archive_date', true );
        $panchco_all_day = get_post_meta( $post->ID, 'panchco_all_day', true );
        ?>
        <p><?php echo __( 'Start Date & Time', 'panchco');?><br>        
        <input class="panchco-datetimepicker" type="text" id="panchco_event_date" name="panchco_event_date" value="<?php echo esc_attr( $panchco_event_date ); ?>" /></p>
        <p><?php echo __( 'End Date & Time', 'panchco');?><br>       
        <input class="panchco-datetimepicker" type="text" id="panchco_end_date" name="panchco_end_date" value="<?php echo esc_attr( $panchco_end_date ); ?>" /></p> 
        <p><input type="checkbox" id="panchco_all_day" name="panchco_all_day" value="y" <?php if($panchco_all_day=="y"){ ?>checked="checked"<?php } ?>/><?php echo __( 'All Day', 'panchco');?></p> 
        <p><?php echo __( 'Archive Date', 'panchco');?><br>      
        <input class="panchco-datetimepicker" type="text" id="panchco_archive_date" name="panchco_archive_date" value="<?php echo esc_attr( $panchco_archive_date ); ?>" /></p>               
        <?php  wp_nonce_field( 'panchco_simple_event_metabox_nonce', 'panchco_simple_event_nonce' ); ?>

    </form>
     
<?php }
  
//-----------------------------------------------------------------------------

function panchco_save_simple_event_meta( $post_id ) {
  
  global $post;
     
    if( !isset( $_POST['panchco_simple_event_nonce'] ) ||
    !wp_verify_nonce( $_POST['panchco_simple_event_nonce'],
    'panchco_simple_event_metabox_nonce'
    ) ) 
return; 
     
    // Check if the current user has permission to edit the post. */
    if ( !current_user_can( 'edit_post', $post->ID ) )
    return;
     
    if ( isset( $_POST['panchco_event_date'] ) ) {        
        $new_event_date = ( $_POST['panchco_event_date'] );
        update_post_meta( $post_id, 'panchco_event_date', $new_event_date );      
    }
    
    if ( isset( $_POST['panchco_end_date'] ) ) {        
        $new_end_date = ( $_POST['panchco_end_date'] );
        update_post_meta( $post_id, 'panchco_end_date', $new_end_date );      
    }
    
    if ( isset( $_POST['panchco_archive_date'] ) ) {        
        $new_archive_date = ( $_POST['panchco_archive_date'] );
        update_post_meta( $post_id, 'panchco_archive_date', $new_archive_date );      
    }
    
    if ( isset( $_POST['panchco_all_day'] ) ) {        
        $new_all_day = ( $_POST['panchco_all_day'] );       
    } else {
        $new_all_day = 'n'; 
    }
    
    update_post_meta( $post_id, 'panchco_all_day', $new_all_day );
     
}

add_action( 'save_post', 'panchco_save_simple_event_meta' );

//-----------------------------------------------------------------------------

/**
 * Load styles and scripts.
 */

function panchco_load_datetimepicker() {
  
    wp_register_style( 'jquery-datetimepicker-css', 
                        plugin_dir_url(__FILE__) . 'js/datetimepicker/jquery.datetimepicker.css',
                        array(),
                        '1.3.4' ); 
                        
 
    wp_register_script( 'jquery-datetimepicker', 
                        plugin_dir_url(__FILE__) . 'js/datetimepicker/jquery.datetimepicker.full.min.js',
                        array('jquery'),
                        '1.3.4', true );    
                        
                        
    wp_register_script( 'panchco-date-meta', 
                        plugin_dir_url(__FILE__) . 'js/plugin.js',
                        array('jquery-datetimepicker'),
                        '1.0.0', true );                   
                        
    wp_enqueue_style( 'jquery-datetimepicker-css' );                                   
    wp_enqueue_script( 'jquery-datetimepicker' );
    wp_enqueue_script( 'panchco-date-meta' );
}

add_action( 'admin_enqueue_scripts', 'panchco_load_datetimepicker' );

//-----------------------------------------------------------------------------

// Options.

function panchco_simple_event_register_settings() {
   add_option( 'panchco_simple_event_post_types', array());
   register_setting( 'panchco_simple_event_options_group', 'panchco_simple_event_post_types' );
}

add_action( 'admin_init', 'panchco_simple_event_register_settings' );

//-----------------------------------------------------------------------------

/**
 * Register plugin options page.
 */
function panchco_simple_event_register_options_page() {
  add_options_page('Simple Event Options', 'Simple Event', 'manage_options', 'panchco_simple_event', 'panchco_simple_event_options_page');
  }
 
/**
 * Display plugin options settings page.
 */  
function panchco_simple_event_options_page() {
  
  // Get the currently registered post types.

  $args = array('public' => true,
                'capability_type' => 'post');
  
  $site_post_types = get_post_types($args);
  
  if( isset($site_post_types['attachment']) ) {
    unset($site_post_types['attachment']);
  }
  
  $post_types = get_option('panchco_simple_event_post_types');
  
  if( ! $post_types || !is_array($post_types)) {
    $post_types = array();
  }
  
//-----------------------------------------------------------------------------
  
  /**
   * Display the form.
   */
  ?>
  <div class="wrap">
  <h2>Simple Event Options</h2>
  <form method="post" action="options.php">
  <?php settings_fields( 'panchco_simple_event_options_group' ); ?>
  <table class="form-table">
  <tr valign="top">
  <th scope="row"><label for="panchco_simple_event_post_types">Post Types</label><p>On which post types do you want the Simple Event date options to appear?</p></th>
  <td>
  <?php foreach($site_post_types as $key => $type ) { ?>
    <input type="checkbox" name="panchco_simple_event_post_types[]" value="<?php echo $key ?>"<?php if(in_array($key,$post_types)) { ?> checked="checked"<?php } ?>/> <?php echo $type;?><br>
  <?php } ?>
  </td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php

}

add_action('admin_menu', 'panchco_simple_event_register_options_page');

//-----------------------------------------------------------------------------

/** 
 * Template functions.
 */
 
 if( ! function_exists('se_event_start') ){
   
   /**
    * Echo event start datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function se_event_start($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_event_date', true);
      
      if( $val ) {
        echo date($format,strtotime($val));
      }
      
      return; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
  if( ! function_exists('se_event_end') ){
   
  /**
    * Echo event end datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function se_event_end($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_end_date', true);
      
      if( $val ) {
        echo date($format,strtotime($val));
      }
      
      return; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
  if( ! function_exists('se_event_archive') ){
   
  /**
    * Echo event archive datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function se_event_archive($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_archive_date', true);
      
      if( $val ) {
        echo date($format,strtotime($val)); 
      }
      
      return; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
   if( ! function_exists('se_all_day') ){
   
   /**
    * Echo event all day event value.
    * @param $post_id int post ID
    * @return string
    */
   function se_all_day($post_id) {
     
      $val = get_post_meta($post_id,'panchco_all_day', true);
      
      if( $val == 'y' ) {
        echo __("Yes"); 
        return;
      }
      
      echo __("No"); 
      return;
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
  if( ! function_exists('get_se_event_start') ){
   
   /**
    * Return event start datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function get_se_event_start($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_event_date', true);
      
      if( $val ) {
        return date($format,strtotime($val));
      }
      
      return false; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
  if( ! function_exists('get_se_event_end') ){
   
   /**
    * Return event end datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function get_se_event_end($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_end_date', true);
      
      if( $val ) {
        return date($format,strtotime($val));
      }
      
      return false; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
  if( ! function_exists('get_se_event_archive') ){
   
   /**
    * Return event archive datetime.
    * @param $post_id int post ID
    * @param $format string PHP date format string.
    * @return mixed
    */
   function get_se_event_archive($post_id, $format='l, F j, Y') {
     
      $val = get_post_meta($post_id,'panchco_archive_date', true);
      
      if( $val ) {
        return date($format,strtotime($val)); 
      }
      
      return false; 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
   if( ! function_exists('get_se_all_day') ){
   
  /**
    * Return event all day value.
    * @param $post_id int post ID
    * @return string
    */
   function get_se_all_day($post_id) {
     
      $val = get_post_meta($post_id,'panchco_all_day', true);
      
      if( $val == 'y' ) {
        return __("Yes"); 
      }
      
      return __("No"); 
   }
   
 }
 
 //-----------------------------------------------------------------------------
 
 
  if( ! function_exists('se_events') ){
   
  /**
    * Return event all day value.
    * @param $post_type string
    * @return $obj
    */
   function se_events($post_type) {
     
     echo $post_type;
          
   }
   
 }
 
 //-----------------------------------------------------------------------------



