<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php wp_title('&mdash;', true, 'right'); bloginfo( 'name' ); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<p><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /><br />
			<?php bloginfo( 'name' ); ?></p>
		</header>
		<nav>
			<?php wp_nav_menu(); ?>
		</nav>
		<section class="main">
			 <?php if ( ! is_page() ) { ?>
				<section class="primary">
			<?php }
			// If we do not have content...
			if ( ! have_posts() ) {
			  // ...then show an error message: ?>
			  <h1>Not Found</h1>
			  <p>Sorry, nothing found.</p>
			<?php 
			// Otherwise...
			} else {
			  // ...as long as there is content to show...
			  while ( have_posts() ) {
				// ...set up each piece of content so we can grab stuff from it:
				the_post();
				if ( is_front_page() ) {
					the_content();
					$latestPost = new WP_Query('posts_per_page=1');
					if ( $latestPost->have_posts() ) {
					// If there is a post to show, add a title before starting the loop: ?>
						<h2>Latest from the blog...</h2>
						<?php while ( $latestPost->have_posts() ) {
							$latestPost->the_post(); ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p class="metadata">Posted on <?php the_time('F jS Y'); ?> at <?php the_time('g:i A'); ?> in <?php the_terms( $post->ID, 'category' ); ?></p>
							<?php the_excerpt();
						} // end while
					} // end if
				} elseif ( is_page() ) {
					// If this is a regular page, just display the title and content: ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail('thumbnail');
					}
					the_content();
				} else {
					// Otherwise, display the title and content plus the metadata
					if ( is_single() ) {
						// If you're viewing a single post, display the title as an h1: ?>
						<h1><?php the_title(); ?></h1>
					<?php } else {
						// Otherwise, display the title as an h3 and link it to the full post: ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php } ?>
					<p class="metadata">Posted on <?php the_time('F jS Y'); ?> at <?php the_time('g:i A'); ?> in <?php the_terms( $post->ID, 'category' ); ?></p>
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'thumbnail', array( 'class' => 'alignright' ) );
					}
					the_content(); ?>
					<p class="aligncenter">
						<?php next_posts_link( '&larr; Older' ); ?>
						&nbsp;&nbsp;&nbsp;
						<?php previous_posts_link( 'Newer &rarr;' ); ?>
					</p>
					<?php comments_template();
				} // end if
			  } // end while
			} // end if
			if ( ! is_page() ) { ?>
				</section><!-- .primary -->
				<aside class="secondary">
					<?php dynamic_sidebar( 'blog-widget-area' ); ?>
				</aside><!-- .secondary -->
				<hr class="clear" />
			<?php } ?>
		</section><!-- .main -->
		<footer>
		    <p>Site by <a href="http://drollic.ca">Linn</a></p>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>