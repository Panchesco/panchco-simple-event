<?php
/*
Plugin Name: Simple Event
Plugin URI: https://github.com/Panchesco/panchco-simple-event
Description: Adds an event date time
Author: Richard Whitmer
Version: 1.0.0
*/
 
 function panchco_simple_event_metabox() {
    add_meta_box( 
        'panchco_simple_event_metabox', 
        __( 'Event Info', 'panchco'), 
        'panchco_simple_event_metabox_callback', 
        array('post'), 
        'side', 
        'low'
    );
}

add_action( 'add_meta_boxes', 'panchco_simple_event_metabox' );

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



