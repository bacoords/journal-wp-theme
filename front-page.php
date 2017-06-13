<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package journal-wp-theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
	
		<main id="main" class="site-main" role="main">
     
      <header class="archive-header">
        
        <h2>Table of Contents</h2>
        
      </header>

      <article id="post-<?php the_ID(); ?>">
      
        <div class="entry-content">

        <?php

        if ( is_user_logged_in() ) :

          if ( have_posts() ) : 

            echo '<ul class="no-bullet">';

            /* Start the Loop */
            while ( have_posts() ) : the_post();

              echo '<li>' . get_the_time('m.d.y') . ' - <a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';

            endwhile;

            echo '</ul>';

            the_posts_navigation(array(
              'prev_text' =>  __('←Backwards'),
              'next_text' =>  __('Forwards→'),
            ));

          else :

            get_template_part( 'template-parts/content', 'none' );

          endif; 

        else : 

          echo '<div class="frontend-login-wrapper">';

          wp_die( __('<p>You must be <a href="'. get_bloginfo('url') .'/wp-login.php">logged in</a>.</p>') );

          echo '</div>';

        endif;
        ?>
        
        </div>
      
      </article>

		</main><!-- #main -->
		
	</div><!-- #primary -->

<?php
get_sidebar();

get_footer();
