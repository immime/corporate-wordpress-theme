<?php
/**
 * Template Name: Products List
 * Displays Custom Post Type "Product" only
 */
?>
<?php get_header(); ?>
    <div id="primary" class="full-width">
        <main id="main" class="prod-browser clearfix" role="main">
            <?php
            //custom post type=product only + take care of pagination as well
            $p_args = array('posts_per_page' => 8,'post_type' => 'product', 'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1);
            query_posts($p_args);
            if (have_posts()) :
                while (have_posts()) : the_post();
                    //we have a separate content file for products
                    get_template_part('content', 'product');
                endwhile;

                // Previous/next page navigation.
                the_posts_pagination(array(
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'mid_size' => 5, //how many links to show on the left and right of the current
                    'end_size' => 2, //how many links to show in the beginning and end of ...
                ));
                //reset query after pagination
                wp_reset_query();
            else :
                get_template_part('content', 'none');
            endif; ?>
        </main>
        <!-- #content -->
    </div><!-- #primary -->
<?php get_footer(); ?>