<?php
// Register menu(s)
register_nav_menus(
	array(
		'main-nav' => 'Main Navigation'
	)
);

// Register widgetized area(s)
function my_widgets_init() {
	register_sidebar(
		array(
			'id'			=> 'blog-widget-area',
			'name'			=> 'Blog Widget Area',
			'description'	=> 'Appears on the blog and single posts.',
			'before_title'	=> '<h3 class="widget-title">',
			'after_title'	=> '</h3>',
			'before_widget'	=> '<section class="blog-widget">',
			'after_widget'	=> '</section><!-- .blog-widget -->',
		)
	);
}
add_action( 'widgets_init', 'my_widgets_init' );

// Register and enqueue styles and scripts
function my_scripts_and_styles() {
	wp_register_style( 'core', get_stylesheet_uri(), false, '1.0', 'all' );
	wp_register_style( 'fonts', 'http://fonts.googleapis.com/css?family=Montserrat', false, '1.0', 'all' );
	wp_enqueue_style( 'core' );
	wp_enqueue_style( 'fonts' );
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'my_scripts_and_styles' );

// Append ellipsis and continue reading link to automatic excerpts
function my_excerpt_more( $more ) {
	return ' &hellip; <a href="'. get_permalink() .'">Continue reading &rarr;</a>';
}
add_filter('excerpt_more', 'my_excerpt_more');

// Register custom image sizes
add_image_size( 'slider', 750, 300, true ); // cropped to exactly 750 pixels wide by 300 pixels tall
add_image_size( 'narrow', 150, 999, false ); // sized to 150 pixels wide and proportional height (max 999 pixels)

// Add custom sizes to the WordPress Media Library
function my_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'slider' => __( 'Image Slider' ),
		'narrow' => __( 'Narrow' )
	) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

// Remove inline WordPress gallery styles
add_filter( 'use_default_gallery_style', '__return_false' );

// Add support for featured images
add_theme_support( 'post-thumbnails' );
?>