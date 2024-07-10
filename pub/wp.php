<?php
$request = wp_remote_get( 'https://mlabusiness.nl/wp-json/wp/v2/posts?_embed' );

if( is_wp_error( $request ) ) {
    return false; // Bail early
}

$body = wp_remote_retrieve_body( $request );

$data = json_decode( $body );

if( ! empty( $data ) ) {

    echo '<ul>';
    foreach( $data->products as $product ) {
        echo '<li>';
        echo '<a href="' . esc_url( $product->info->link ) . '">' . $product->info->title . '</a>';
        echo '</li>';
    }
    echo '</ul>';
}