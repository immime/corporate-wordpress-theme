<?php
/**
 * Theme Header Section for our theme.
 *
 * Displays all of the <head> section and everything up till [div id="content"]
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <?php flush(); //speed tweak?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
    <header id="masthead" class="site-header" role="banner">
        <div class="inner-wrap clearfix">
            <div class="site-branding">
                <?php
                $head_logo = get_corpo_option('logo_image', '');
                $head_choice = get_corpo_option('logo_opt', 2); //1-logo only,2=headings only,3=both
                if (($head_choice == 1 || $head_choice == 3) && $head_logo !== '') {
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img class="site-logo" src="<?php echo esc_url($head_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"></a>
                <?php
                }  //show heading + also if logo is not set
                if ($head_choice == 2 || $head_choice == 3 || $head_logo === '') {
                    ?>
                    <hgroup class="header-text">
                        <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <h2 class="site-description"><?php bloginfo('description'); ?></h2><!-- #site-description -->
                    </hgroup><!-- .header-text -->
                <?php
                }
                unset($head_logo);
                unset($head_choice);
                ?>
            </div>
            <!-- .site-branding -->
            <button class="menu-toggle toggle-btn" aria-expanded="false"><i class="fa fa-navicon"></i><span class="screen-reader-text">Toggle Menu</span></button>
            <div class="main-nav-parent">
                <nav id="site-navigation" class="main-navigation" role="navigation">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array('theme_location' => 'primary', 'container' => ''));
                    } else {
                        wp_page_menu($show_home = 1);
                    }
                    ?>
                </nav>
                <button class="search-toggle toggle-btn"><i class="fa fa-search"></i><span class="screen-reader-text">Toggle Search</span>
                </button>
                <div class="nav-search-box">
                    <?php get_template_part('searchform', 'two'); ?>
                </div>
            </div>
            <!-- .main-nav-parent -->
        </div>
    </header>
    <!--.site-header-->
    <?php if (!(is_front_page())) { ?>
        <section class="page-title-bar">
            <div class="inner-wrap clearfix">
                <div class="page-title-wrap"><h1><?php echo corpo_header_title(); ?></h1></div>
                <?php
                //Breadcrumb NavXT plugin support // or if u have custom code for that ; call here
                if (function_exists('bcn_display')) {
                    echo '<div class="breadcrumbs">';
                    echo '<span class="breadcrumbs-before">You are here:</span>';
                    bcn_display();
                    echo '</div>';
                }
                ?>
            </div>
        </section><!--page-title-bar-->
    <?php } // if not front page ends?>
    <div id="content" class="site-content<?php echo (!is_front_page()) ? ' inner-wrap ' : '' ?> clearfix">