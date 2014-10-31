<?php
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
                'label'       => __( 'Wayfair link', 'woocommerce' ), 
                'placeholder' => 'enter Wayfair link',
                'desc_tip'    => 'true',
                'description' => __( 'Enter link to Wayfair page.', 'woocommerce' ) 
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
