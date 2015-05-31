<?php
/**
 * The template for displaying Comments.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required())
    return;
?>
<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            printf(_n('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number()),
                number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
            ?>
        </h2>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
            <nav class="navigation comment-navigation clearfix" role="navigation">
                <span class="screen-reader-text">Comment navigation</span>
                <?php
                if ($prev_link = get_previous_comments_link('&larr;  Older Comments')) :
                    printf('<div class="nav-previous">%s</div>', $prev_link);
                endif;

                if ($next_link = get_next_comments_link('Newer Comments &rarr;')) :
                    printf('<div class="nav-next">%s</div>', $next_link);
                endif;
                ?>
            </nav><!-- #comment-nav-above -->
        <?php endif; // check for comment navigation ?>
        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ul',
                'avatar_size' => 0, //disabled
                'short_ping' => true
            ));
            ?>
        </ul><!-- .comment-list -->
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // are there comments to navigate through ?>
            <nav class="navigation comment-navigation clearfix" role="navigation">
                <span class="screen-reader-text">Comment navigation</span>
                <?php
                if ($prev_link = get_previous_comments_link('&larr;  Older Comments')) :
                    printf('<div class="nav-previous">%s</div>', $prev_link);
                endif;

                if ($next_link = get_next_comments_link('Newer Comments &rarr;')) :
                    printf('<div class="nav-next">%s</div>', $next_link);
                endif;
                ?>
            </nav><!-- #comment-nav-below -->
        <?php endif; // check for comment navigation ?>
    <?php endif; // have_comments() ?>
    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments">Comments are closed.</p>
    <?php endif; ?>
    <?php comment_form(); ?>
</div><!-- #comments -->