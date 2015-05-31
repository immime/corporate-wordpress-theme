<?php
/**
 * index.php for our theme.
 *
 */
?>
<?php get_header(); ?>
    <div id="primary">
        <main id="main" class="clearfix" role="main">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('content', get_post_format());
                endwhile;

                // Previous/next page navigation.
                the_posts_pagination(array(
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'mid_size' => 5, //how many links to show on the left and right of the current
                    'end_size' => 2, //how many links to show in the beginning and end of ...
                ));

            else :
                get_template_part('content', 'none');
            endif; ?>
        </main>
        <!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>