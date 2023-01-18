<?php

/**
 * Testimonial Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'testimonial-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'testimonial';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}
?>
<div id="<?php echo esc_attr( $id ); ?>"
     class="<?php echo esc_attr( $className ); ?> <?php echo trim( get_field( 'testimonial_alignment' ) ) ?: ''; ?>"
     style="background-color: <?php echo get_field( 'background_color' ) ?: '#eaeaea' ?>;
             padding-top:<?php echo get_field( 'padding_top' ) . 'px' ?: '' ?>;
             padding-bottom:<?php echo get_field( 'padding_bottom' ) . 'px' ?: '' ?>;
             padding-left:<?php echo get_field( 'padding_left' ) . 'px' ?: '' ?>;
             padding-right:<?php echo get_field( 'padding_right' ) . 'px' ?: '' ?>;
             ">
    <blockquote class="testimonial-blockquote">
        <span class="testimonial-text"
              style="color: <?php echo get_field( 'description_color' ) ?: '#000000'; ?>"><?php echo get_field( 'description' ) ?: 'Your testimonial here..'; ?></span>
        <span class="testimonial-author"
              style="color: <?php echo get_field( 'author_name_color' ) ?: '#000000'; ?>"><?php echo get_field( 'author' ) ?: 'Author name'; ?></span>
        <span class="testimonial-role"
              style="color: <?php echo get_field( 'author_role_color' ) ?: '#c4c4c4'; ?>"><?php echo get_field( 'author_role' ) ?: 'Author role'; ?></span>
    </blockquote>
    <div class="testimonial-image"
         style="border-radius:<?php echo get_field( 'image_border_radius' ) . 'px' ?: '100px' ?> ;">
        <img style="border-radius:<?php echo get_field( 'image_border_radius' ) . 'px' ?: '100px' ?> ;"
             src="<?php echo get_field( 'author_image' ) ?: 'https://source.unsplash.com/300x300/?person'; ?>"
             alt="<?php echo get_field( 'author' ) ?: 'Author name'; ?>">
    </div>
</div>
