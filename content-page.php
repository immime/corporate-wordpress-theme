<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content clearfix">
        <?php
        the_content();
        wp_link_pages(array(
            'before' => '<div class="page-links clearfix">' . __('Pages:'),
            'after' => '</div>',
            'link_before' => '<span>',
            'link_after' => '</span>'
        ));
        edit_post_link(__('Edit'), '<span class="edit-link"><i class="fa fa-edit">&ensp;</i>', '</span>');
        ?>
    </div>
</article>