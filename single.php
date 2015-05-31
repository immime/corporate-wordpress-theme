<?php
/**
 * Theme Single Post Section for our theme.
 *
 */
?>
<?php get_header(); ?>
    <div id="primary">
        <main id="main" class="clearfix" role="main">
            <?php while (have_posts()) : the_post();
                get_template_part('content', 'single');
                ?>
                <ul class="default-wp-page clearfix">
                    <?php  //we can create a separate image.php for all image attachments
                    if (is_attachment()) {
                        ?>
                        <li class="previous"><?php previous_image_link(false, __('&larr; Previous')); ?></li>
                        <li class="next"><?php next_image_link(false, __('Next &rarr;')); ?></li>
                    <?php
                    } else {
                        ?>
                        <li class="previous"><?php previous_post_link('%link', '<i class="fa fa-angle-double-left"></i><span>%title</span>'); ?></li>
                        <li class="next"><?php next_post_link('%link', '<span>%title</span><i class="fa fa-angle-double-right"></i>'); ?></li>
                    <?php
                    }?>
                </ul>
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; ?>
        </main>
        <!-- #content -->
    </div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>