<?php
/**
 * The Sidebar containing the main widget areas.
 *
 */
//return early if sidebar has no widgets
if ( ! is_active_sidebar( 'corpo_right_sidebar' ) ) {
    return;
}
?>
<div id="secondary" class="widget-area" role="complementary">
<?php dynamic_sidebar( 'corpo_right_sidebar' ); ?>
</div>