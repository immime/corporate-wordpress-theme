<?php
/**
 * Static Home Page , made of widgets
 * Displays the Business Template of the theme.
 *
 */
?>
<?php get_header(); ?>
<?php
//call the slider
corpo_featured_image_slider();
//call top sidebar
if (is_active_sidebar('corpo_business_top_sidebar')) {
    dynamic_sidebar('corpo_business_top_sidebar');
}
?>
    <main id="main" class="inner-wrap clearfix" role="main">
        <?php
        if (is_active_sidebar('corpo_business_sidebar')) {
            dynamic_sidebar('corpo_business_sidebar');
        }
        ?>
    </main>
<?php get_footer(); ?>