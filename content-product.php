<?php
/**
 * The template used for displaying products in index-product.php
 *
 */
?>
<article <?php post_class('prod-box'); ?> id="post-<?php the_ID(); ?>">
    <a rel="bookmark" title="<?php the_title_attribute() ?>" href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('featured-blog-small', array('alt' => get_the_title())); ?>
    </a>
    <h2 class="prod-title">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
    </h2>
    <footer class="prod-meta">
        <?php
        $product_categories = get_the_term_list(get_the_ID(), 'product-category', '', ', ', '');
        if ($product_categories) {
            printf('<span class="prod-cat"><i class="fa fa-folder-open"></i>&ensp;%1$s</span>', $product_categories);
        }
        ?>
    </footer>
    <div class="prod-more">
        <a href="<?php the_permalink(); ?>"><i class="fa fa-eye"></i> View Details</a>
    </div>
</article>