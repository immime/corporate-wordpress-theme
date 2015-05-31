<?php
/*
 * functions.php for our theme
 * @package : Corpo
 */


/* no direct access to this file*/
if (!defined('ABSPATH')) exit;

add_action('after_setup_theme', 'corpo_theme_setup');


    function corpo_theme_setup()
    {


        // Set the content width based on the theme's design and stylesheet.
        global $content_width;
        if (!isset($content_width))
            $content_width = 768;

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
        add_theme_support('post-thumbnails');

        // Registering navigation menus.
        register_nav_menus(array(
            'primary' => 'Primary/Main Menu',
            'footer' => 'Footer Menu'
        ));

        // Cropping the images to different sizes to be used in the theme
        add_image_size('featured-blog-small', 230, 160, true);
        // Adding excerpt option box for pages as well
        add_post_type_support('page', 'excerpt');
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));
        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.  WP v4.1+
         */
        add_theme_support('title-tag');

        //Note: no support to post formats

    }



/** Load more functions */
require(get_template_directory() . '/inc/more-functions.php');
/* Load customizer*/
require(get_template_directory() . '/inc/customizer.php');
/* Load Widgets  */
require(get_template_directory() . '/inc/widgets.php');
/* Load custom post types  */
require(get_template_directory() . '/inc/cpt-product.php');


?>