<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style';
	$theme        = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array(),
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		$theme->get( 'Version' )
	);
}

/**
 * Register ACF Blocks
 */
add_action( 'acf/init', 'hfm_acf_init_block_types' );
function hfm_acf_init_block_types() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		// register our custom block
		acf_register_block_type( array(
			'name'            => 'testimonial',
			'title'           => __( 'Testimonial', 'twentynineteenchild' ),
			'description'     => __( 'A custom testimonial block', 'twentynineteenchild' ),
			'render_template' => "/blocks/testimonial/testimonial.php",
			'enqueue_style'   => get_template_directory_uri() . "-child/blocks/testimonial/testimonial.css",
			'category'        => 'text',
			'icon'            => array(
				// Specifying a background color to appear with the icon e.g.: in the inserter.
				'background' => '#7e70af',
				// Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
				'foreground' => '#fff',
				// Specifying a dashicon for the block
				'src'        => 'admin-comments',
			),
			'keywords'        => array( 'testimonial', 'quote' ),
			'post_types'      => array( 'post', 'page' ),
			'align'           => array( 'left', 'right', 'full' ),
			'align_text'      => true,
			'align_content'   => true,
		) );
	}
}


add_action( 'acf/init', 'wp_posts_block_types' );
function wp_posts_block_types() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		// register our custom block
		acf_register_block_type( array(
			'name'            => 'posts',
			'title'           => __( 'Posts', 'twentynineteenchild' ),
			'description'     => __( 'Showing WordPress Posts', 'twentynineteenchild' ),
			'render_template' => "/blocks/post/post.php",
			'enqueue_style'   => get_template_directory_uri() . "-child/blocks/post/post.css",
			'category'        => 'text',
			'icon'            => array(
				'background' => '#FFA500',
				'foreground' => '#fff',
				'src'        => 'admin-post',
			),
			'keywords'        => array( 'post', 'products' ),
			'post_types'      => array( 'post', 'page' ),
			'align'           => array( 'left', 'right', 'full' ),
			'align_text'      => true,
			'align_content'   => true,
		) );
	}
}


/* Excerpt Filter */

add_filter( 'excerpt_length', function ( $length ) {
	return 20;
}, 999 );


/**
 * Register Custom Post Type
 */
function book_register_post_type() {
	$labels = array(
		'name'               => __( 'Books', 'twentynineteenchild' ),
		'singular_name'      => __( 'Book', 'twentynineteenchild' ),
		'add_new'            => __( 'Add New Book', 'twentynineteenchild' ),
		'add_new_item'       => __( 'Add New Book', 'twentynineteenchild' ),
		'edit_item'          => __( 'Edit Book', 'twentynineteenchild' ),
		'new_item'           => __( 'New Book', 'twentynineteenchild' ),
		'view_item'          => __( 'View Books', 'twentynineteenchild' ),
		'search_items'       => __( 'Search Books', 'twentynineteenchild' ),
		'not_found'          => __( 'No Books Found', 'twentynineteenchild' ),
		'not_found_in_trash' => __( 'No Books found in Trash', 'twentynineteenchild' ),
	);
	$args   = array(
		'labels'        => $labels,
		'has_archive'   => true,
		'public'        => true,
		'hierarchical'  => false,
		'menu_icon'     => 'dashicons-book-alt',
		'supports'      => array(
			'title',
			'thumbnail',
			'editor'
		),
		'rewrite'       => array( 'slug' => 'book' ),
		'show_in_rest ' => true
	);

	register_post_type( 'book', $args );
}

add_action( 'init', 'book_register_post_type' );


/**
 * @param $field
 *
 * @return array
 * Get All Registered Post Types
 */

function get_all_post_types() {
	$all_post_type        = [];
	$assocs_all_post_type = array();

	$args       = array(
		'public' => true,
	);
	$post_types = get_post_types( $args, false );
	unset( $post_types['attachment'] );
	foreach ( $post_types as $post_type_obj ):
		$labels = get_post_type_labels( $post_type_obj );
		array_push( $all_post_type, $labels->singular_name );
	endforeach;
	foreach ( $all_post_type as $val ) {
		$assocs_all_post_type[ $val ] = $val;
	}

	return $assocs_all_post_type;
}

function tnc_load_color_field_choices( $field ) {

	$all_post_types = get_all_post_types();
	// reset choices
	$field['choices'] = $all_post_types;

	// return the field
	return $field;

}

add_filter( 'acf/load_field/name=post_type', 'tnc_load_color_field_choices' );




/**
 * Custom Hooks
 */

// tnc_before_post_image
//add_action( 'tnc_before_post_image', function () {
//	echo "i am before post image";
//} );

// tnc_after_post_image
//add_action( 'tnc_after_post_image', function () {
//	echo "i am after post image";
//} );

// tnc_before_post_content
//add_action( 'tnc_before_post_content', function () {
//	echo "i am before post content";
//} );

// tnc_after_post_content
//add_action( 'tnc_after_post_content', function () {
//	echo "i am after post content";
//} );

// tnc_before_post_excerpt
//add_action( 'tnc_before_post_excerpt', function () {
//	echo "i am before post excerpt";
//} );

// tnc_after_post_excerpt
//add_action( 'tnc_after_post_excerpt', function () {
//	echo "i am after post excerpt";
//} );

// tnc_before_post_title
//add_action( 'tnc_before_post_title', function () {
//	echo "i am before post title";
//} );

// tnc_after_post_title
//add_action( 'tnc_after_post_title', function () {
//	echo "i am after post title";
//} );
