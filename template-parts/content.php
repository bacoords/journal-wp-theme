<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package journal-wp-theme
 */


   $cat = get_the_category();
   $color = get_term_meta( $cat[0]->term_id, 'color', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php if($color) echo 'style="border: 5px solid' . $color . '"';?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">' . get_the_time('m.d.y') . ' - ', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_time('m.d.y') . ' - ', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
<!--		<div class="entry-meta">-->
			<?php // journal_wp_theme_posted_on(); ?>
<!--		</div> -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'journal-wp-theme' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'journal-wp-theme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php journal_wp_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
