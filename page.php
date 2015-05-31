<?php
/**
 * Theme Page Section for our theme.
 *
 */
?>
<?php get_header(); ?>
    <div id="primary">
        <main id="main" class="clearfix" role="main">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('content', 'page'); ?>
                <?php
                // If comments are open or we have at least one comment, load up the comment template
                if (comments_open() || '0' != get_comments_number())
                    comments_template();
                ?>
            <?php endwhile; ?>
        </main>
        <!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>