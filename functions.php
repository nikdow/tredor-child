<?php

add_action( 'wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);
function enqueue_child_theme_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array('parent-style')  );
}


/*
 * Woo commerce customisation to show link to online retailer for each item
 * http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
 */
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'woo_add_custom_general_fields' );
 
// Save Fields
add_action( 'woocommerce_process_product_meta', 'woo_add_custom_general_fields_save' );

function woo_add_custom_general_fields() {
 
  global $woocommerce, $post;
  
  echo '<div class="options_group">';
  
    woocommerce_wp_text_input( 
        array( 
                'id'          => '_wayfair_link', 
                'label'       => __( 'Zizo link', 'woocommerce' ), 
                'placeholder' => 'enter Zizo link',
                'desc_tip'    => 'true',
                'description' => __( 'Enter link to Zizo page, including http:// at the start.', 'woocommerce' ) 
        )
    );
  
  echo '</div>';
}

function woo_add_custom_general_fields_save( $post_id ){
	
	// Wayfair link
	$woocommerce_text_field = $_POST['_wayfair_link'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, '_wayfair_link', esc_attr( $woocommerce_text_field ) );
}

add_action('woocommerce_product_meta_end', 'woo_display_custom_fields' );

function woo_display_custom_fields ( ) {
    
    global $post, $product;
    
    $post_id = $product->id;
    
    $wayfair_link = get_post_meta($post_id, '_wayfair_link', true );
    
    if( $wayfair_link ) {
        ?>
        <div class="product_meta">
            <a href="<?=$wayfair_link?>" target="_blank">Buy online at Zizo</a>
        </div>
<?php
    }
}
/*
 * remove theme sales pitch
 * see function unite_footer_links in theme extras.php
 */
function clean_footer() {
    remove_action( 'unite_footer', 'unite_footer_info', 30 ); 
}
add_action('loop_end', 'clean_footer', 1);
