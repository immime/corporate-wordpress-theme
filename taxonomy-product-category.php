<?php
/**
 * The template for displaying Product's Category  archives
 *
 */
?>
<?php get_header(); ?>
    <div id="primary" class="full-width">
        <main id="main" class="clearfix" role="main">
            <?php if (have_posts()) : ?>
                <header class="entry-header">
                    <h3 class="entry-title">
                    <?php global $wp_query;
                    echo $wp_query->found_posts; ?> Products in the <?php single_cat_title(); ?> category</h3>
                </header>
                <table class="prod-tbl" cellspacing="0">
                    <thead>
                    <tr> <th>#</th> <th><i class="fa fa-asterisk"></i> Product Name</th> <th><i class="fa fa-list-alt"></i> Composition</th> <th><i class="fa fa-medkit"></i> Packaging</th> </tr>
                    </thead>
                    <tbody>
                    <?php
                    global $posts_per_page;
                    $curr_page = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
                    $sn = ($curr_page - 1) * $posts_per_page + 1;
                    while (have_posts()) : the_post();
                        ?>
                        <tr>
                            <td><?php echo $sn; ?></td>
                            <td><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a><i class="fa fa-arrow-right"></i></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'prod_composition', true); ?></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'prod_packaging', true); ?></td>
                        </tr>
                        <?php $sn++; endwhile; ?>
                    </tbody>
                </table>
                <?php
                unset($sn,$curr_page);//free memory
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
<?php get_footer(); ?>