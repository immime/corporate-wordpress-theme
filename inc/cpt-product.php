<?php
/*
 * This file contains CPT=Product specific functions
 */

//register new custom post type
function corpo_custom_post_type_init()
{
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'menu_name' => 'Products',
        'name_admin_bar' => 'Product',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Product',
        'new_item' => 'New Product',
        'edit_item' => 'Edit Product',
        'view_item' => 'View Product',
        'all_items' => 'All Products',
        'search_items' => 'Search Products',
        'parent_item_colon' => 'Parent Products:',
        'not_found' => 'No Products found.',
        'not_found_in_trash' => 'No Products found in Trash.',
    );
    $args = array(
        'labels' => $labels,
        'description' => 'Products',
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false, //keep it false to make product-cat list page working
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-products',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 5,
        'taxonomies' => array(),
        'rewrite' => array('slug' => 'product/%product-category%', 'with_front' => false), //slug hack
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
    );
    register_post_type('product', $args);

    $tax_args = array(
        'public' => true,
        'hierarchical' => true,
        'label' => 'Product Category',
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-category'),
    );

    register_taxonomy('product-category', array('product'), $tax_args);

}

add_action('init', 'corpo_custom_post_type_init', 1);

//@source : https://wordpress.org/support/topic/insert-category-of-taxonomy-between-custom-post-type-and-post
add_filter('post_link', 'corpo_product_permalink', 1, 3);
add_filter('post_type_link', 'corpo_product_permalink', 1, 3);

function corpo_product_permalink($permalink, $post_id, $leavename)
{

    if (strpos($permalink, '%product-category%') === FALSE) return $permalink;
    // Get post
    $post = get_post($post_id);
    if (!$post) return $permalink;

    // Get taxonomy terms
    $terms = wp_get_object_terms($post->ID, 'product-category');
    if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0]))
        $taxonomy_slug = $terms[0]->slug; //first term only
    else $taxonomy_slug = 'uncategorized';

    return str_replace('%product-category%', $taxonomy_slug, $permalink);
}

//change post messages
function corpo_alter_post_messages($messages)
{
    global $post, $post_ID;
    $messages['product'] = array(
        0 => '',//unused
        1 => sprintf(__('Product updated. <a href="%s">View product</a>'), esc_url(get_permalink($post_ID))),
        2 => __('Custom field updated.'),
        3 => __('Custom field deleted.'),
        4 => __('Product updated.'),
        5 => isset($_GET['revision']) ? sprintf(__('Product restored to revision from %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
        6 => sprintf(__('Product published. <a href="%s">View product</a>'), esc_url(get_permalink($post_ID))),
        7 => __('Product saved.'),
        8 => sprintf(__('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
        9 => sprintf(__('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
        10 => sprintf(__('Product draft updated. <a target="_blank" href="%s">Preview product</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

if (is_admin())
add_filter('post_updated_messages', 'corpo_alter_post_messages');


// Change the menu item labels
//http://www.bechster.com/renaming-wordpress-admin-menu-names-labels/
function corpo_change_post_menu_label()
{
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    if (current_user_can('edit_posts')) {
        $submenu['edit.php'][5][0] = 'All Articles';
    }
    if (current_user_can('publish_posts')) {
        $submenu['edit.php'][10][0] = 'Add Article';
    }
    if (current_user_can('manage_categories')) {
        $submenu['edit.php'][15][0] = 'Article Category';
        $submenu['edit.php'][16][0] = 'Article Tags';
    }

}

if (is_admin())
add_action('admin_menu', 'corpo_change_post_menu_label');


function corpo_filter_product_queries($query)
{
    //filter search results - search inside post only
    if ($query->is_search() && $query->is_main_query()) {
        $query->set('post_type', 'post');
    }
    //product category page will show 20 items in table
    if ($query->is_tax('product-category') && $query->is_main_query()) {
        $query->set('posts_per_page', 20);
    }
    return $query;
}

if (!is_admin())
add_filter('pre_get_posts', 'corpo_filter_product_queries');


//add a meta box to product post
if (is_admin())
    add_action('add_meta_boxes', 'corpo_init_product_meta_box');
function corpo_init_product_meta_box()
{
    add_meta_box(
        'product_meta_box',   //id
        'Product Information',
        'corpo_show_product_meta_box', //callback function
        'product',//post-type
        'side'   //position
    );
}

function corpo_show_product_meta_box($post)
{   //wp inbuilt security
    wp_nonce_field(basename(__FILE__), 'product_meta_box_nonce');
    ?>
<p>
<label for="prod_composition">Product Composition</label>
<input class="widefat" type="text" id="prod_composition" name="prod_composition" value="<?php echo esc_attr(get_post_meta($post->ID, 'prod_composition', true)) ?>"/>
</p>
<p>
<label for="prod_packaging">Product Packaging</label>
<input class="widefat" type="text" id="prod_packaging" name="prod_packaging" value="<?php echo esc_attr(get_post_meta($post->ID, 'prod_packaging', true)) ?>"/>
</p>
<?php
}

if (is_admin())
    add_action('save_post', 'corpo_save_product_meta_box');
       //save meta box fields to db
function corpo_save_product_meta_box($post_id)
{

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    if (!isset($_POST['product_meta_box_nonce']) || !wp_verify_nonce($_POST['product_meta_box_nonce'], basename(__FILE__)))
        return;

    if (!isset($_POST['post_type']) || 'product' !== $_POST['post_type'])
        return;

    update_post_meta($post_id, 'prod_packaging', sanitize_text_field($_POST['prod_packaging']));
    update_post_meta($post_id, 'prod_composition', sanitize_text_field($_POST['prod_composition']));
}


// Add Custom Post Type Stats to WP-ADMIN Right Now Dashboard Widget
function corpo_right_now_content_append()
{

    if (!current_user_can('edit_posts')) return;

    $args = array(
        'public' => true,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';
    $post_types = get_post_types($args, $output, $operator);
    foreach ($post_types as $post_type) {
        $num_posts = wp_count_posts($post_type->name);
        $num = number_format_i18n($num_posts->publish);
        $text = _n($post_type->labels->singular_name, $post_type->labels->name, intval($num_posts->publish));
        $cpt_name = $post_type->name;

        echo '<li class="' . $cpt_name . '-count"><a href="edit.php?post_type=' . $cpt_name . '">' . $num . ' ' . $text . '</a></li>';
    }

    if (!current_user_can('manage_categories')) return;
    $taxonomies = get_taxonomies($args, $output, $operator);
    foreach ($taxonomies as $taxonomy) {
        $num_terms = wp_count_terms($taxonomy->name);
        $num = number_format_i18n($num_terms);
        $text = _n($taxonomy->labels->name, $taxonomy->labels->name, intval($num_terms));
        $cpt_tax = $taxonomy->name;
        echo '<li class="' . $cpt_tax . '-count"><a href="edit-tags.php?taxonomy=' . $cpt_tax . '">' . $num . ' ' . $text . '</a></li>';
    }
    //style icons as well
    ?>
    <style type="text/css">
        li.product-count a:before { content: "\f312" !important; }
        li.product-category-count a:before { content: "\f318" !important; }
    </style>
<?php

}

if (is_admin())
add_action('dashboard_glance_items', 'corpo_right_now_content_append');

// https://yoast.com/custom-post-type-snippets/
// Filter the request to just give posts for the given taxonomy, if applicable.
function corpo_taxonomy_filter_restrict_manage_posts()
{
    global $typenow;

    // If you only want this to work for your specific post type,
    // check for that $type here and then return.
    // This function, if unmodified, will add the dropdown for each
    // post type / taxonomy combination.

    $post_types = get_post_types(array('_builtin' => false));

    if (in_array($typenow, $post_types)) {
        $filters = get_object_taxonomies($typenow);

        foreach ($filters as $tax_slug) {
            $tax_obj = get_taxonomy($tax_slug);
            wp_dropdown_categories(array(
                'show_option_all' => __('Show All ' . $tax_obj->label),
                'taxonomy' => $tax_slug,
                'name' => $tax_obj->name,
                'orderby' => 'name',
                'selected' => isset($_GET[$tax_slug]) ? absint($_GET[$tax_slug]) : '',
                'hierarchical' => $tax_obj->hierarchical,
                'show_count' => false,
                'hide_empty' => true
            ));
        }
    }
}

if (is_admin())
add_action('restrict_manage_posts', 'corpo_taxonomy_filter_restrict_manage_posts');
//add a filter to the query so the dropdown will actually work:
function corpo_taxonomy_filter_post_type_request($query)
{
    global $pagenow, $typenow;

    if ('edit.php' == $pagenow) {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $var = &$query->query_vars[$tax_slug];
            if (isset($var)) {
                $term = get_term_by('id', $var, $tax_slug);
                $var = $term->slug;
            }
        }
    }
}

if (is_admin())
add_filter('parse_query', 'corpo_taxonomy_filter_post_type_request');
?>