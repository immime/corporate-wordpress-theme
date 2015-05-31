<?php
/**
 * Theme functions and definitions
 *
 */


function corpo_load_user_styles()
{
    /** Loads our main stylesheet. */
    wp_enqueue_style('corpo-theme-main', get_stylesheet_uri(), array(), null);
    // Setup font arguments //best way to create font url
    $query_args = array(
        'family' => urlencode(implode('|', array('Roboto:400,700,700italic,400italic,300,300italic', 'Roboto Slab:700,400,300'))),
    );
    wp_enqueue_style('corpo-web-fonts', add_query_arg($query_args, "//fonts.googleapis.com/css"), array(), null);
    wp_enqueue_style('font-awesome', corpo_get_fa_url(), array(), null);

}

add_action('wp_enqueue_scripts', 'corpo_load_user_styles', 1);

function corpo_load_user_scripts()
{

    /* Enqueue my jquery*/
    wp_deregister_script('jquery');
    wp_register_script('jquery', corpo_get_jquery_url(), array(), null, 1);
    wp_enqueue_script('jquery');

    /** Enqueue Slider  js file. */
    if (is_front_page()) {
        wp_enqueue_script('jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array('jquery'), null, true);
    }
    wp_enqueue_script('corpo-theme-custom', get_template_directory_uri() . '/js/site-custom.js', array('jquery'), null, true);
    wp_enqueue_script('prefix-free', get_template_directory_uri() . '/js/prefixfree.min.js', array(), null, true);


}

add_action('wp_enqueue_scripts', 'corpo_load_user_scripts', 9);

//Best way to enqueue comment js
add_action('comment_form_before', 'corpo_enqueue_comments_reply');
function corpo_enqueue_comments_reply()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

function corpo_get_jquery_url()
{
    if (corpo_is_localhost()) {
        return get_template_directory_uri() . '/js/jquery-2.1.3.min.js';
    } else {
        return "//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js";
    }
}

function corpo_get_fa_url()
{
    if (corpo_is_localhost()) {
        return get_template_directory_uri() . '/icons/css/font-awesome.min.css';
    } else {
        return "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css";
    }
}

function corpo_is_localhost()
{
    //tells if site is running on localhost or not
    if (isset($_SERVER['SERVER_ADDR']) && in_array($_SERVER['SERVER_ADDR'], array('127.0.0.1', '::1'))) {
        return true;
    } else {
        return false;
    }
}

/****************************************************************************************/
//will be used on blog index page
add_filter('excerpt_length', 'corpo_excerpt_length');
function corpo_excerpt_length($length)
{
    return 60;
}

/** Alter "Continue Reading" link for excerpts */
add_filter('excerpt_more', 'corpo_continue_reading');
function corpo_continue_reading()
{
    if (!is_front_page()) {
        return ' [...]';
    } else {
        return '';
    }

}

/****************************************************************************************/

/**
 * Removing the default style of wp gallery
 */
add_filter('use_default_gallery_style', '__return_false');


/****************************************************************************************/
/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
if (!is_admin())
    add_filter('body_class', 'corpo_body_class');
function corpo_body_class($classes)
{
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }
    if (!is_front_page()) {
        //don't add these class when static front-page is being shown
        $layout = get_corpo_option('layout', '2');//1=left,2=right,
        if ($layout == '1') {
            $classes[] = 'left-sidebar';
        } else {
            $classes[] = 'right-sidebar';
        }

        //full width page if right sidebar not active
        if (!is_active_sidebar('corpo_right_sidebar')) {
            $classes[] = 'full-width';
        }
    }


    return $classes;
}

//****************************************************************************************/

//single function to show post meta ; stolen from twentyfifteen theme
function corpo_entry_meta()
{
    ?>
    <footer class="entry-footer clearfix">
        <?php
        if (is_sticky() && is_home() && !is_paged()) {
            printf('<span class="sticky-post"><i class="fa fa-star"> </i>%s</span>', 'Featured');
        }
        if (is_singular() || is_multi_author()) {
            printf('<span class="byline"><span class="author vcard"><i class="fa fa-user"></i><a class="url fn n" href="%1$s">%2$s</a></span></span>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                get_the_author()
            );
        }
        //prepare a standard template string
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date())
        );
        printf('<span class="posted-on"><i class="fa fa-calendar-o"></i><a href="%1$s" title="%2$s" rel="bookmark">%3$s</a></span>',
            esc_url(get_permalink()),
            esc_attr(get_the_time()),
            $time_string
        );

        $categories_list = get_the_category_list(', ');
        if ($categories_list) {
            printf('<span class="cat-links"><i class="fa fa-folder-open"></i>%1$s</span>', $categories_list);
        }
        //was added for cpt=product
        $product_categories = get_the_term_list(get_the_ID(), 'product-category', '', ', ', '');
        if ($product_categories) {
            printf('<span class="cat-links"><i class="fa fa-folder-open"></i>&ensp;%1$s</span>', $product_categories);
        }
        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list && is_single()) {
            printf('<span class="tags-links"><i class="fa fa-tags"></i>%1$s</span>', $tags_list);
        }
        if (is_attachment() && wp_attachment_is_image()) {
            // Retrieve attachment metadata.
            $metadata = wp_get_attachment_metadata();
            printf('<span class="full-size-link"><i class="fa fa-search-plus"></i><a href="%1$s">%2$s &times; %3$s</a></span>',
                esc_url(wp_get_attachment_url()),
                $metadata['width'],
                $metadata['height']
            );
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            ?>
            <span class="comments-link"><i class="fa fa-comment"></i><?php comments_popup_link('No Comments', '1 Comment', '% Comments', '', 'Comments Off'); ?></span> <?php
        }
        edit_post_link(__('Edit'), '<span class="edit-link"><i class="fa fa-edit"></i>', '</span>'); ?>
        <?php
        if (!is_single()) {
            ?><span class="read-more-link"><a class="read-more" href="<?php the_permalink(); ?>">Read more&ensp;<i class="fa fa-arrow-right"></i></a></span><?php
        }
        ?>
    </footer>
<?php
}

/****************************************************************************************/

/** Fav icon for the site */

add_action('admin_head', 'corpo_set_favicon', 90);
add_action('wp_head', 'corpo_set_favicon', 90);
function corpo_set_favicon()
{   //get url from customizer
    $favicon = get_corpo_option('favicon');
    if ($favicon) {
        printf('<link rel="shortcut icon" href="%1$s"/>', esc_url($favicon));
    }
}


/**
 * display  slider  on home page
 */
function corpo_featured_image_slider()
{
    ob_start();
    $array_image = (array)(get_corpo_option('slide_img'));
    $slide_meta_off = get_corpo_option('slide_meta_off');
    $array_title = (array)get_corpo_option('slide_head');
    $array_text = (array)get_corpo_option('slide_desc');
    $array_btn = (array)get_corpo_option('slide_btn');
    $array_link = (array)get_corpo_option('slide_url');
    ?>
    <section id="featured-slider" class="slider-cycle">
        <div class="slider-rotate">
            <?php
            //we support 5 slides
            for ($i = 0; $i <= 4; $i++) {
                $slider_image = $array_image[$i];  //image path
                $slider_title = $array_title[$i];
                $slider_text = $array_text[$i];
                $slider_btn = $array_btn[$i];
                $slider_link = $array_link[$i];
                //don't show if img ath is not set
                if (!empty($slider_image) && $slider_image !== '') {
                    ?>
                    <div class="slides" <?php if ($i != 0) echo ' style="display:none;" '; ?>>
                        <img alt="<?php echo esc_attr($slider_title); ?>" src="<?php echo esc_url($slider_image); ?>">
                        <?php if (!$slide_meta_off) { ?>
                            <div class="slider-meta-wrap">
                                <div class="slider-meta">
                                    <?php if (!empty($slider_title)) { ?>
                                        <h1 class="slider-title animated fadeInLeftBig"><?php echo esc_html($slider_title) ?></h1>
                                    <?php } ?>
                                    <?php if (!empty($slider_text)) { ?>
                                        <h3 class="slider-description animated zoomIn"><?php echo esc_html($slider_text); ?></h3>
                                    <?php } ?>
                                    <?php if (!empty($slider_link)) { ?>
                                        <div class="slider-button">
                                            <a href="<?php echo esc_url($slider_link) ?>"><?php echo esc_html($slider_btn) ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!--slider meta -->
                            </div>
                        <?php } ?>
                    </div><!--end slide-->
                <?php } //end if image not empty ?>
            <?php }//end for loop ?>
        </div>
        <!--slider rotate-->
        <div class="slider-nav">
            <a class="slide-next" href="#"><i class="fa fa-angle-right"></i></a>
            <a class="slide-prev" href="#"><i class="fa fa-angle-left"></i></a>
        </div>
    </section> <!--slider cycle-->
    <?php
    //just strip white space
    echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
}//end slider fn

function corpo_header_title()
{

//show title in page title bar along with breadcrumbs

   if (is_single() || (is_home() && !is_front_page()) || (is_page() && !is_front_page())) {
        $title = single_post_title('', false);
    } else if (is_archive()) {
        $title = get_the_archive_title(); //wp v4.1+

    } elseif (is_404()) {
        $title = __('Page not found');
    } elseif (is_search()) {
        $title = 'Search results';
    } else {
        $title = '';
    }
    if ($title == '') {
        //show post id if title is not set
        if (is_single() || is_page()) {
            $title = get_the_ID();
        }
    }
    return $title;

}

//add id (column) to post listing page
if (is_admin()) {
    add_filter('manage_posts_columns', 'corpo_posts_columns_id', 5);
    add_filter('manage_pages_columns', 'corpo_posts_columns_id', 5);
    add_action('manage_posts_custom_column', 'corpo_posts_custom_id_columns', 5, 2);
    add_action('manage_pages_custom_column', 'corpo_posts_custom_id_columns', 5, 2);
}
function corpo_posts_columns_id($defaults)
{
    $defaults['corpo_post_id'] = __('ID');
    return $defaults;
}

function corpo_posts_custom_id_columns($column_name, $id)
{
    if ($column_name === 'corpo_post_id') {
        echo $id;
    }
}


//remove url field from comment form
if (!is_admin())
    add_filter('comment_form_default_fields', 'alter_comment_form_default_fields');

function alter_comment_form_default_fields($fields)
{
    unset($fields['url']);
    return $fields;
}


/* if there is no title, show post id */
if (!is_admin())
    add_filter('the_title', 'corpo_set_default_title');

function corpo_set_default_title($title)
{

    if (trim($title) === '')
        $title = 'Untitled: ' . get_the_ID();
    return $title;

}

//force  user to select a category before saving  a post
if (is_admin()) {
    add_action('admin_footer-post.php', 'corpo_post_form_validation_js', 99);
    add_action('admin_footer-post-new.php', 'corpo_post_form_validation_js', 99);
}
function corpo_post_form_validation_js()
{
    global $post_type;
    //for posts only
    if ($post_type === 'post') {
        echo '<script type="text/javascript">';
        echo @file_get_contents(get_template_directory() . '/js/admin/post-form-validation.js');
        echo '</script>';
    } else if ($post_type === 'product') {
        echo '<script type="text/javascript">';
        echo @file_get_contents(get_template_directory() . '/js/admin/product-form-validation.js');
        echo '</script>';
    }
}

?>