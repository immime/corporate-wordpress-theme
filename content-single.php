<?php
/**
 * The template used for displaying page content in single.php
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>
    <div class="entry-content clearfix">
        <?php
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links clearfix">' . __('Pages:'),
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>'
        ));
        ?>
    </div>
    <?php corpo_entry_meta(); ?>
</article>