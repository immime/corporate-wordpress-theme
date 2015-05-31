<?php
/**
 * Contains all the classes/functions related to sidebar and widget.
 */

add_action('widgets_init', 'corpo_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function corpo_widgets_init()
{

    // Registering main right sidebar
    register_sidebar(array(
        'name' => 'Right Sidebar',
        'id' => 'corpo_right_sidebar',
        'description' => 'Shows widgets at Right side.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));


    // Registering footer sidebar one
    register_sidebar(array(
        'name' => 'Footer Column One',
        'id' => 'corpo_footer_sidebar_one',
        'description' => 'Shows widgets at footer Column one.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));

    // Registering footer sidebar two
    register_sidebar(array(
        'name' => 'Footer Column Two',
        'id' => 'corpo_footer_sidebar_two',
        'description' => 'Shows widgets at footer Column two.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));

    // Registering footer sidebar three
    register_sidebar(array(
        'name' => 'Footer Column Three',
        'id' => 'corpo_footer_sidebar_three',
        'description' => 'Shows widgets at footer Column three.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));
    // Registering footer sidebar three
    register_sidebar(array(
        'name' => 'Footer Column Four',
        'id' => 'corpo_footer_sidebar_four',
        'description' => 'Shows widgets at footer Column four.',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title"><span>',
        'after_title' => '</span></h3>'
    ));
    // Registering Business Page template sections
    register_sidebar(array(
        'name' => 'Business Page Top Widget',
        'id' => 'corpo_business_top_sidebar',
        'description' => 'Shows widgets on Business Page Top.',
        'before_widget' => '<section id="%1$s" class="widget %2$s ">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'name' => 'Business Page Widgets',
        'id' => 'corpo_business_sidebar',
        'description' => 'Shows widgets on Business Page Template.',
        'before_widget' => '<section id="%1$s" class="widget %2$s clearfix">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    ));


    // Registering widgets
    register_widget("ank_featured_single_page_widget");
    register_widget("ank_custom_tag_widget");
    register_widget("ank_recent_post_extended_widget");
    register_widget("ank_our_clients_widget");
    register_widget("ank_promo_box_widget");
    register_widget("ank_testimonial_widget");
    register_widget("ank_recent_work_widget");
    register_widget("ank_call_to_action_widget");
    register_widget("ank_our_service_widget");
    register_widget("ank_slogan_box_widget");
    register_widget("ank_floating_form_widget");
    register_widget("Ank_Social_Menu_Widget");

}

/****************************************************************************************/

/**
 * Featured Single page widget.
 *
 */
class ank_featured_single_page_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_featured_single', 'description' => 'Display Featured Single Page (Business)');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_featured_single_page_widget', $name = 'AK: Featured Single Page', $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('page_id' => '', 'title' => ''));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
                   type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('page_id'); ?>">Page:</label>
            <?php wp_dropdown_pages(array('name' => $this->get_field_name('page_id'), 'selected' => absint($instance['page_id']))); ?>
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['page_id'] = absint($new_instance['page_id']);
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);

        $title = isset($instance['title']) ? $instance['title'] : '';
        $page_id = isset($instance['page_id']) ? absint($instance['page_id']) : '';

        if ($page_id) {
            $the_query = new WP_Query('page_id=' . $page_id);
            $output = '';
            while ($the_query->have_posts()):$the_query->the_post();
                $page_name = get_the_title();
                $output .= $args['before_widget'];
                if (has_post_thumbnail()) {
                    $output .= '<figure class="image-wrap" >' . get_the_post_thumbnail(get_the_ID(), 'thumbnail', array('title' => esc_attr($page_name), 'alt' => esc_attr($page_name))) . '</figure>';
                }
                $output .= '<div class="content-wrap" >';
                if ($title): $output .= $args['before_title'] . '<a href="' . get_permalink() . '" title="' . esc_attr($title) . '">' . esc_html($title) . '</a>' . $args['after_title'];
                else: $output .= $args['before_title'] . '<a href="' . get_permalink() . '" title="' . esc_attr($page_name) . '">' . esc_html($page_name) . '</a>' . $args['after_title'];
                endif;

                $output .= '<p>' . get_the_excerpt() . '</p>';

                $output .= '</div>';
                $output .= $args['after_widget'];
            endwhile;
            // Reset Post Data
            wp_reset_query();
            echo $output;
        }

    }
}

/**************************************************************************************/

/**
 * Featured call to action widget.
 */
class ank_call_to_action_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_call_to_action', 'description' => 'Show the call to action section.');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_call_to_action_widget', $name = 'AK: Call To Action Widget', $widget_ops, $control_ops);
    }


    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('text_main' => '', 'text_additional' => '', 'button_text' => '', 'button_url' => ''));
        ?><p>
        <label>Call to Action Main Text:</label>
        <textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('text_main'); ?>"
                  name="<?php echo $this->get_field_name('text_main'); ?>"><?php echo esc_textarea($instance['text_main']); ?></textarea>
        </p><p><label>Call to Action Additional Text:</label>
        <textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('text_additional'); ?>"
                  name="<?php echo $this->get_field_name('text_additional'); ?>"><?php echo esc_textarea($instance['text_additional']); ?></textarea>
    </p><p>
        <label for="<?php echo $this->get_field_id('button_text'); ?>">Button Text:</label><br>
        <input class="widefat" id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>"/>
    </p>
        <p>
            <label for="<?php echo $this->get_field_id('button_url'); ?>">Button Redirect Link:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo esc_url($instance['button_url']); ?>"/>
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        if (current_user_can('unfiltered_html'))
            $instance['text_main'] = $new_instance['text_main'];
        else
            $instance['text_main'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text_main']))); // wp_filter_post_kses() expects slashed

        if (current_user_can('unfiltered_html'))
            $instance['text_additional'] = $new_instance['text_additional'];
        else
            $instance['text_additional'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text_additional']))); // wp_filter_post_kses() expects slashed

        $instance['button_text'] = strip_tags($new_instance['button_text']);
        $instance['button_url'] = esc_url_raw($new_instance['button_url']);

        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);

        $text_main = empty($instance['text_main']) ? '' : $instance['text_main'];
        $text_additional = empty($instance['text_additional']) ? '' : $instance['text_additional'];
        $button_text = isset($instance['button_text']) ? $instance['button_text'] : '';
        $button_url = isset($instance['button_url']) ? $instance['button_url'] : '#';
        ob_start();
        echo $args['before_widget'];
        ?>
        <div class="call-to-action-content-wrapper clearfix" >
            <div class="call-to-action-content">
                <?php
                if (!empty($text_main)) {
                    ?>
                    <h3><?php echo esc_html($text_main); ?></h3>
                <?php
                }
                if (!empty($text_additional)) {
                    ?>
                    <p><?php echo esc_html($text_additional); ?></p>
                <?php
                }
                ?>
            </div>
            <?php
            if (!empty($button_text)) {
                ?>
                <a class="read-more" href="<?php echo esc_url($button_url); ?>" title="<?php echo esc_attr($button_text); ?>"><?php echo esc_html($button_text); ?></a>
            <?php
            }
            ?>
        </div>
        <?php
        echo $args['after_widget'];
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }
}


/****************************************************************************************/

/**
 * Featured service widget to show pages.
 */
class ank_our_service_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_our_service', 'description' => 'Display some pages as services (Business).');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_image_service_widget', $name = 'AK: Our Services', $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $defaults = array('button_text' => '', 'btn_on' => 'on');
        for ($i = 0; $i < 6; $i++) {
            $defaults['page_id' . $i] = '';
            $defaults['icon_class' . $i] = '';
        }
        $instance = wp_parse_args((array)$instance, $defaults);

        ?>
        <p class="description">Font-awesome icon list is available <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">here</a> </p>
        <?php for ($i = 0; $i < 6; $i++) {
        $page_id = 'page_id' . $i;
        $icon_class = 'icon_class' . $i;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id($page_id); ?>">Select Page <b><?php echo $i + 1; ?></b>:</label>
            <?php wp_dropdown_pages(array('show_option_none' => ' ', 'name' => $this->get_field_name($page_id), 'selected' => absint($instance[$page_id]))); ?>
            <br><label for="<?php echo $this->get_field_id($icon_class); ?>">Font awesome icon class:</label>
            <input class="widefat" placeholder="fa-rocket" type="text" name="<?php echo $this->get_field_name($icon_class); ?>" id="<?php echo $this->get_field_id($icon_class); ?>" value="<?php echo esc_attr($instance[$icon_class]); ?>">
        </p>
        <hr>
    <?php } ?>
        <p>
            <label for="<?php echo $this->get_field_id('button_text'); ?>">Button text:</label>
            <input placeholder="Read More" type="text" name="<?php echo $this->get_field_name('button_text'); ?>" id="<?php echo $this->get_field_id('button_text'); ?>" value="<?php echo esc_attr($instance['button_text']) ?>">
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['button_text'] = sanitize_text_field($new_instance['button_text']);
        for ($i = 0; $i < 6; $i++) {
            $instance['page_id' . $i] = absint($new_instance['page_id' . $i]);
            $instance['icon_class' . $i] = sanitize_html_class($new_instance['icon_class' . $i]);
        }

        return $instance;
    }

    function this_excerpt_length()
    {
        return 40;
    }

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        $button_text = empty($instance['button_text']) ? '' : $instance['button_text'];

        $page_array = array();
        $icon_array = array();
        for ($i = 0; $i < 6; $i++) {
            $page_id = isset($instance['page_id' . $i]) ? $instance['page_id' . $i] : '';

            if (!empty($page_id)) {
                array_push($page_array, $page_id);// Push the page id in the array
                $icon_array[$page_id] = $instance['icon_class' . $i];
            }
        }
        // Limit the number of words in in this widget only
        add_filter('excerpt_length', array($this, 'this_excerpt_length'));

        $get_featured_pages = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => array('page'),
            'post__in' => $page_array,
            'orderby' => 'post__in'
        ));
        echo $args['before_widget']; ?>
        <?php
        $j = 1;
        while ($get_featured_pages->have_posts()):$get_featured_pages->the_post();

            if ($j % 2 == 1 && $j > 1) {
                $service_class = "tg-one-third tg-one-third-last";
            } else
                if ($j % 3 == 1 && $j > 1) {
                    $service_class = "tg-one-third tg-after-three-blocks-clearfix";
                } else {
                    $service_class = "tg-one-third";
                }
            ?>
            <div class="service-box <?php echo $service_class; ?>" >
                <div class="service-icon"><i class="fa <?php echo sanitize_html_class($icon_array[get_the_ID()]) ?>"></i> </div>
                <h2><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
                <?php if ($button_text !== ''): ?>
                    <a title="<?php the_title_attribute(); ?>" class="view-more" href="<?php the_permalink(); ?>"><?php echo esc_html($button_text) ?></a>
                <?php endif; ?>
            </div>
            <?php $j++; ?>
        <?php endwhile;
        wp_reset_query();
        // remove filter - must
        remove_filter('excerpt_length', array($this, 'this_excerpt_length'));
        ?>
        <?php
        echo $args['after_widget'];
    }
}

/**************************************************************************************/

/**
 *  Custom Tag Widget
 */
class ank_custom_tag_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_custom_tagcloud', 'description' => 'Custom Tag Cloud');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_custom_tag_widget', $name = 'AK: Custom Tag Cloud', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);
        $title = empty($instance['title']) ? 'Tags' : $instance['title'];

        echo $args['before_widget'];

        if ($title):
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        endif;

        wp_tag_cloud('smallest=13&largest=13px&unit=px');

        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args(( array )$instance, array('title' => 'Tags'));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>
    <?php
    }
}


//CUSTOM RECENT POSTS  extended

class ank_recent_post_extended_widget extends WP_Widget
{
    //using trimmed version of widget
    function __construct()
    {
        $widget_ops = array('classname' => 'widget-rpew', 'description' => 'Extended Post List with images');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct('ank_recent_post_extended_widget', 'AK: Extended Recent Post List', $widget_ops, $control_ops);

    }


    function  widget($args, $instance)
    {
        ob_start();

        extract($args);
        extract($instance);
        $title = (!empty($instance['title'])) ? $instance['title'] : '';
        $count = empty($instance['post_count']) ? 5 : absint($instance['post_count']);
        $post_types = (is_array($instance['post_types'])) ? $instance['post_types'] : array('post');
        $include_sticky = ($instance['sticky_on'] == 'on') ? false : true;
        $order_by = (empty($instance['order_by'])) ? 'date' : $instance['order_by'] . ' ID';; //adding a fallback
        $order = ($instance['order'] != '0') ? 'DESC' : 'ASC';
        //prepare query arguments


        $query_args = array(
            'no_found_rows' => true,
            'post_type' => $post_types,
            'posts_per_page' => $count,
            'post_status' => 'publish',
            'ignore_sticky_posts' => $include_sticky,
            'orderby' => $order_by,
            'order' => $order,
            'date_query' => array(
                array(
                    'after' => $instance['posts_time'],
                ),
            )
        );

        //execute query
        $my_query = new WP_Query($query_args);
        if ($my_query->have_posts()) {
            echo $args['before_widget'];
            if ($title):
                echo $args['before_title'] . $title . $args['after_title'];
            endif;
            echo "<ul class='rpew-list " . esc_attr($instance['ul_class']) . "'>";
            while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <li class="clearfix">
                    <?php if (has_post_thumbnail() && $instance['img_on']) { ?>
                    <a rel="bookmark" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"> <?php echo get_the_post_thumbnail(get_the_ID(), array(80, 80), array('class' => 'rpew-img')); ?> </a><?php } ?>
                    <a class="rpew-title" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    <?php
                    if ($instance['time_on']):
                        printf('<span class="rpew-time">%1$s</span>', get_the_date());
                    endif;
                    if ($instance['cat_on']):
                        $categories_list = get_the_category_list($separator = ', ', $post_id = get_the_ID());
                        if ($categories_list) printf('<span class="rpew-cat">in %1$s</span>', $categories_list);
                        // this is a temporary fix -   just to display product category
                        $product_categories = get_the_term_list(get_the_ID(), 'product-category', '', ', ', '');
                        if ($product_categories) printf('<span class="rpew-cat">in %1$s</span>', $product_categories);
                    endif;
                    ?>
                </li>
            <?php
            endwhile;
            echo "</ul>";
            echo $args['after_widget'];
            wp_reset_postdata();
        }
        wp_reset_query();
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }


    function  update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['post_types'] = $new_instance['post_types']; //array
        $instance['order'] = sanitize_text_field($new_instance['order']);
        $instance['order_by'] = sanitize_text_field($new_instance['order_by']);
        $instance['posts_time'] = sanitize_text_field($new_instance['posts_time']);
        $instance['img_on'] = isset($new_instance['img_on']);
        $instance['time_on'] = isset($new_instance['time_on']);
        $instance['cat_on'] = isset($new_instance['cat_on']);
        $instance['sticky_on'] = isset($new_instance['sticky_on']);
        $instance['ul_class'] = sanitize_html_class($new_instance['ul_class']);
        $instance['post_count'] = intval(sanitize_text_field($new_instance['post_count']));

        return $instance;

    }

    function form($config)
    {
        ob_start();
        $config = wp_parse_args(( array )$config, array('title' => 'Recent Posts', 'post_count' => 5, 'time_on' => 1, 'img_on' => 1, 'cat_on' => 1, 'sticky_on' => 0, 'order_by' => 'date', 'order' => '1', 'ul_class' => '', 'posts_time' => '0', 'post_types' => array('post')));
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:</label>
            <input placeholder="Recent Posts" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" type="text" value="<?php echo esc_attr($config['title']) ?>" name="<?php echo $this->get_field_name('title'); ?>">
        </p>
        <p><label><b>Post Types:</b> (default:Posts)</label>
        <ul>
            <?php
            foreach (get_post_types(array('public' => true), 'objects') as $type) {
                echo "<li>" . '<label><input value="' . esc_attr($type->name) . '" type="checkbox" name="' . $this->get_field_name('post_types') . '[]"' . checked(in_array($type->name, (array)$config['post_types']), true, false) . ' /> ' . esc_html($type->labels->name) . "</label></li>\n";
            }
            ?></ul>
        </p>
        <hr>
        <p><label for="<?php echo $this->get_field_id('order'); ?>">Order:</label>
            <select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>">
                <option value="1" <?php selected($config['order'], '1'); ?>>Descending (default)</option>
                <option value="0" <?php selected($config['order'], '0'); ?>>Ascending</option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id('order_by'); ?>">Order by:</label>
            <select name="<?php echo $this->get_field_name('order_by'); ?>" id="<?php echo $this->get_field_id('order_by'); ?>">
                <option value="none" <?php selected($config['order_by'], 'none'); ?>>None (No Order)</option>
                <option value="title" <?php selected($config['order_by'], 'title'); ?>>Post Title</option>
                <option value="date" <?php selected($config['order_by'], 'date'); ?>>Post Date (default)</option>
                <option value="modified" <?php selected($config['order_by'], 'modified'); ?>>Date Modified</option>
                <option value="rand" <?php selected($config['order_by'], 'rand'); ?>>Random Posts</option>
                <option value="comment_count" <?php selected($config['order_by'], 'comment_count'); ?>>Popular (Most Commented)</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("posts_time"); ?>">Posts from:</label>
            <select id="<?php echo $this->get_field_id("posts_time"); ?>" name="<?php echo $this->get_field_name("posts_time"); ?>">
                <option value="0"<?php selected($config["posts_time"], "0"); ?>>All time</option>
                <option value="1 year ago"<?php selected($config["posts_time"], "1 year ago"); ?>>This year</option>
                <option value="1 month ago"<?php selected($config["posts_time"], "1 month ago"); ?>>This month</option>
                <option value="1 week ago"<?php selected($config["posts_time"], "1 week ago"); ?>>This week</option>
                <option value="1 day ago"<?php selected($config["posts_time"], "1 day ago"); ?>>Past 24 hours</option>
            </select>
        </p>
        <p><label for="<?php echo $this->get_field_id('img_on'); ?>">Show Featured Image:</label>
            <input id="<?php echo $this->get_field_id('img_on'); ?>" type="checkbox"  <?php checked($config['img_on'], true, true); ?> name="<?php echo $this->get_field_name('img_on'); ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('time_on'); ?>">Show Post Time:</label>
            <input id="<?php echo $this->get_field_id('time_on'); ?>" type="checkbox"  <?php checked($config['time_on'], true, true); ?> name="<?php echo $this->get_field_name('time_on'); ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('cat_on'); ?>">Show Categories:</label>
            <input id="<?php echo $this->get_field_id('cat_on'); ?>" type="checkbox"  <?php echo checked($config['cat_on'], true, true); ?> name="<?php echo $this->get_field_name('cat_on'); ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('sticky_on'); ?>">Include Sticky Posts:</label>
            <input id="<?php echo $this->get_field_id('sticky_on'); ?>" type="checkbox"  <?php checked($config['sticky_on'], true, true); ?> name="<?php echo $this->get_field_name('sticky_on'); ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('ul_class'); ?>">Add this class to &lt;ul&gt;:</label>
            <input placeholder="rpew-ul" size="10" id="<?php echo $this->get_field_id('ul_class'); ?>" type="text" value="<?php echo esc_attr($config['ul_class']) ?>" name="<?php echo $this->get_field_name('ul_class'); ?>">
        </p>
        <p><label for="<?php echo $this->get_field_id('post_count'); ?>">Number of posts to show:</label>
            <input size="3" placeholder="5" id="<?php echo $this->get_field_id('post_count'); ?>" type="text" value="<?php echo esc_attr($config['post_count']) ?>" name="<?php echo $this->get_field_name('post_count'); ?>">
        </p>
        <?php
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }
}

/**************************************************************************************/

/**
 * Widget for business layout that shows Promo Box.
 */
class ank_promo_box_widget extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_promotional_bar ', 'description' => 'Display PromoBox ( Business )');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_promo_box_widget', $name = 'AK: Promo Box', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $widget_primary = empty($instance['promo']) ? '' : $instance['promo'];

        echo $args['before_widget'];
        if (!empty($widget_primary)) {
            ?>
            <div class="promotional-text" >
                <h3><?php echo esc_html($widget_primary) ?></h3>
                <p><?php echo esc_html($instance['sub_promo']); ?></p>
            </div>
            <a class="read-more" href="<?php echo esc_url($instance['btn_url']); ?>" title="<?php echo esc_attr($instance['btn_text']); ?>"><?php echo esc_html($instance['btn_text']); ?>&ensp;<i class="fa fa-angle-double-right"></i></a>
        <?php
        }
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['promo'] = esc_textarea($new_instance['promo']);
        $instance['sub_promo'] = esc_textarea($new_instance['sub_promo']);
        $instance['btn_text'] = sanitize_text_field($new_instance['btn_text']);
        $instance['btn_url'] = esc_url_raw($new_instance['btn_url']);
        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('promo' => '', 'sub_promo' => '', 'btn_text' => '', 'btn_url' => ''));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('promo'); ?>">Primary Promotional:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('promo'); ?>"
                      name="<?php echo $this->get_field_name('promo'); ?>"><?php echo esc_textarea($instance['promo']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sub_promo'); ?>">Secondary Promotional:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('sub_promo'); ?>"
                      name="<?php echo $this->get_field_name('sub_promo'); ?>"><?php echo esc_textarea($instance['sub_promo']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_text'); ?>">Redirect Text:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo esc_attr($instance['btn_text']); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_url'); ?>">Redirect Url:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_url'); ?>" name="<?php echo $this->get_field_name('btn_url'); ?>" type="text" value="<?php echo esc_url($instance['btn_url']); ?>"/>
        </p>
    <?php
    }
}


/**
 * Widget for business layout that shows slogan Box.
 */
class ank_slogan_box_widget extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_slogan_bar ', 'description' => 'Display Slogan ( Business Top )');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_slogan_box_widget', $name = 'AK: Slogan Box', $widget_ops, $control_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $widget_slogan = empty($instance['slogan']) ? '' : $instance['slogan'];

        echo $args['before_widget'];
        if (!empty($widget_slogan)) {
            ?>
            <div class="inner-wrap clearfix">
                <div class="slogan-text">
                    <h3><?php echo esc_html($widget_slogan) ?></h3>
                    <p><?php echo esc_html($instance['sub_slogan']); ?></p></div>
                <a class="slogan-action" href="<?php echo esc_url($instance['btn_url']); ?>" title="<?php echo esc_attr($instance['btn_text']); ?>"><?php echo esc_html($instance['btn_text']); ?></a>
            </div>
        <?php
        }
        echo $args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['slogan'] = esc_textarea($new_instance['slogan']);
        $instance['sub_slogan'] = esc_textarea($new_instance['sub_slogan']);
        $instance['btn_text'] = sanitize_text_field($new_instance['btn_text']);
        $instance['btn_url'] = esc_url_raw($new_instance['btn_url']);
        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('slogan' => '', 'sub_slogan' => '', 'btn_text' => '', 'btn_url' => ''));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('slogan'); ?>">Primary Slogan:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('slogan'); ?>" name="<?php echo $this->get_field_name('slogan'); ?>"><?php echo esc_textarea($instance['slogan']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sub_slogan'); ?>">Secondary Slogan:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('sub_slogan'); ?>" name="<?php echo $this->get_field_name('sub_slogan'); ?>"><?php echo esc_textarea($instance['sub_slogan']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_text'); ?>">Button Text:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo esc_attr($instance['btn_text']); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_url'); ?>">Redirect Url:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('btn_url'); ?>" name="<?php echo $this->get_field_name('btn_url'); ?>" type="text" value="<?php echo esc_url($instance['btn_url']); ?>"/>
        </p>
    <?php
    }
}

//testimonial // fixed
class ank_testimonial_widget extends WP_Widget
{

    function __construct()
    {
        $widget_ops = array('classname' => 'widget_testimonial', 'description' => 'Display Testimonial (Business)');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::__construct('ank_testimonial_widget', $name = 'AK: Testimonial', $widget_ops, $control_ops);
        //media upload script
        add_action('admin_enqueue_scripts', array($this, 'atw_scripts'));
    }

    function atw_scripts($hook)
    {
        //enqueue only to widget page
        if ($hook !== 'widgets.php') return;
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        add_action('admin_print_scripts', array($this, 'ank_media_upload_js'), 9999);
    }

    function ank_media_upload_js()
    {
        //this script will allow user to upload/select image even on widget page
        ?>
        <script type="text/javascript">jQuery(function (a) { a(document).on("click", ".ank_upload_image", function () { a.data(document.body, "prevElement", a(this).prev("input.img_url")); window.send_to_editor = function (c) { var b = a("img", c).attr("src"); var d = a.data(document.body, "prevElement"); if (d != undefined && d != "") { d.val(b) } tb_remove() }; tb_show("", "media-upload.php?type=image&amp;tab=library&amp;TB_iframe=true"); return false }) });</script>
    <?php
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = empty($instance['title']) ? '' : $instance['title'];
        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        for ($i = 1; $i <= 2; $i++) {
            ?>
            <div class="tg-one-half <?php echo ($i == '2') ? ' tg-one-half-last' : ''; ?>" >
                <div class="testimonial-wrap">
                    <div class="testimonial-post">
                        <i class="fa fa-quote-left"></i>
                        <p><?php echo esc_textarea($instance['text' . $i]); ?></p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-author-detail">
                            <span class="author-name"><?php echo esc_html($instance['name' . $i]); ?></span><br>
                            <span class="author-desc"><?php echo esc_html($instance['byline' . $i]) ?></span>
                        </div>
                        <div class="testimonial-author-image">
                            <img title="author" alt="author" src="<?php echo esc_url($instance['image' . $i]); ?>">
                        </div>
                    </div>
                </div>
                <!-- .testimonial-wrap -->
            </div><!-- .tg-one-half -->
        <?php
        } //end loop
        echo $args['after_widget'];

    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        for ($i = 1; $i <= 2; $i++) {
            $instance['name' . $i] = strip_tags($new_instance['name' . $i]);
            $instance['image' . $i] = esc_url_raw($new_instance['image' . $i]);
            $instance['byline' . $i] = strip_tags($new_instance['byline' . $i]);
            if (current_user_can('unfiltered_html'))
                $instance['text' . $i] = $new_instance['text' . $i];
            else
                $instance['text' . $i] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text' . $i])));
        }//end for loop
        return $instance;
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => '', 'name1' => '', 'image1' => '', 'byline1' => '', 'text1' => '', 'name2' => '', 'image2' => '', 'text2' => '', 'byline2' => ''));

        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>
        <?php
        for ($i = 1; $i <= 2; $i++) {
            $name = 'name' . $i;
            $image = 'image' . $i;
            $byline = 'byline' . $i;
            $text = 'text' . $i;
            ?>
            <p><label for="<?php echo $this->get_field_id($name); ?>">Name <b><?php echo $i ?></b>:</label>
                <input class="widefat" id="<?php echo $this->get_field_id($name); ?>" name="<?php echo $this->get_field_name($name); ?>" type="text" value="<?php echo esc_html($instance[$name]); ?>"/>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id($byline); ?>">Byline :</label>
                <input class="widefat" id="<?php echo $this->get_field_id($byline); ?>" name="<?php echo $this->get_field_name($byline); ?>" type="text" value="<?php echo esc_html($instance[$byline]); ?>"/>
            </p>
            <p><label>Image URL <b><?php echo $i ?></b>:</label><br>
                <input class="img_url" size="20" placeholder="Image URL" id="<?php echo $this->get_field_id($image); ?>" name="<?php echo $this->get_field_name($image); ?>" type="text" value="<?php echo esc_url($instance[$image]); ?>"/>
                <input placeholder="Image url" type="button" class="button ank_upload_image" value="Upload">
            </p>
            <label>Testimonial Description:</label>
            <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id($text); ?>"
                      name="<?php echo $this->get_field_name($text); ?>"><?php echo esc_textarea($instance[$text]); ?></textarea>
            <hr>
        <?php
        }//end loop
    }
}

/**
 * Widget for business layout that shows Featured page title and featured image. fixed
 */
class ank_recent_work_widget extends WP_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_recent_work', 'description' => 'Show recent work, portfolio etc. (Business)');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget('ank_recent_work_widget', $name = 'AK: Featured Recent Work', $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $defaults = array('title' => '', 'text' => '', 'btn_text' => '', 'btn_url' => '');
        for ($i = 0; $i < 3; $i++) {
            $defaults['page_id' . $i] = '';
        }
        $instance = wp_parse_args((array)$instance, $defaults);
        ?>
        <p class="description">You can enter ID from 'Custom Post Types' (Public) also.</p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_html($instance['title']); ?>"/>
        </p>
        <label>Description:</label>
        <textarea class="widefat" rows="4" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($instance['text']); ?></textarea>
        <p>
            <label for="<?php echo $this->get_field_id('btn_text'); ?>">Button Text:</label>
            <input id="<?php echo $this->get_field_id('btn_text'); ?>" name="<?php echo $this->get_field_name('btn_text'); ?>" type="text" value="<?php echo esc_attr($instance['btn_text']); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('btn_url'); ?>">Redirect Url:</label>
            <input id="<?php echo $this->get_field_id('btn_url'); ?>" name="<?php echo $this->get_field_name('btn_url'); ?>" type="text" value="<?php echo esc_url($instance['btn_url']); ?>"/>
        </p>
        <hr>
        <?php
        for ($i = 0; $i < 3; $i++) {
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('page_id' . $i); ?>">Page/Post ID :</label>
                <input type="text" size="15" name="<?php echo $this->get_field_name('page_id' . $i) ?>" id="<?php $this->get_field_id('page_id' . $i); ?>" value="<?php echo absint($instance['page_id' . $i]) ?>">
            </p>
        <?php
        }
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['btn_url'] = esc_url_raw($new_instance['btn_url']);
        $instance['btn_text'] = strip_tags($new_instance['btn_text']);
        $instance['text'] = esc_html($new_instance['text']);

        for ($i = 0; $i < 3; $i++) {
            $instance['page_id' . $i] = absint($new_instance['page_id' . $i]);
        }

        return $instance;
    }

    function this_excerpt_length()
    {
        return 30;
    }

    function widget($args, $instance)
    {
        extract($args);
        extract($instance);

        $page_array = array();
        for ($i = 0; $i < 3; $i++) {
            $page_id = isset($instance['page_id' . $i]) ? $instance['page_id' . $i] : '';

            if (!empty($page_id))
                array_push($page_array, $page_id);// Push the page id in the array
        }
        // Limit the number of words in in this widget only
        add_filter('excerpt_length', array($this, 'this_excerpt_length'));

        //include custom post types also //some users may want this
        $post_types = get_post_types(array('public' => true));
        $get_featured_pages = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => $post_types,
            'post__in' => $page_array,
            'post_status' => 'publish',
            'orderby' => 'post__in',
            'ignore_sticky_posts' => true,
        ));
        ob_start();
        echo $args['before_widget']; ?>
        <div class="column clearfix">
        <div class="tg-one-fourth" >
            <?php echo $args['before_title'] . esc_html($instance['title']) . $args['after_title']; ?>
            <p><?php echo esc_textarea($instance['text']); ?></p>
            <a class="read-more" href="<?php echo esc_url($instance['btn_url']); ?>" title="<?php echo esc_attr($instance['btn_text']); ?>"><?php echo esc_html($instance['btn_text']); ?></a>
        </div>
        <?php
        $j = 1;
        while ($get_featured_pages->have_posts()):$get_featured_pages->the_post();
            ?>
            <div class="tg-one-fourth <?php echo ($j == 3) ? ' tg-one-fourth-last' : '' ?>" >
                <figure class="recent_work_img">
                    <?php
                    if (has_post_thumbnail()) {
                        echo '<a title="' . esc_attr(get_the_title()) . '" ' . 'href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'featured-blog-small') . '</a>';
                    }
                    ?></figure>
                <h3 class="recent_work_title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p class="recent_work_excerpt"><?php echo get_the_excerpt(); ?></p>
            </div>
            <?php  $j++;
        endwhile;
        // Reset Post Data
        wp_reset_query();
        // don't forget to remove filter
        remove_filter('excerpt_length', array($this, 'this_excerpt_length'));
        ?>
        <?php
        echo '</div>';
        echo $args['after_widget'];
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }
}

class ank_our_clients_widget extends WP_Widget
{
    //we are using testimonial widget upload helper javascript here
    function __construct()
    {
        $widget_ops = array('classname' => 'widget_our_clients', 'description' => 'Use to show your clients logos or any thing.(Business)');
        $control_ops = array('width' => 200, 'height' => 250);
        parent::WP_Widget(false, $name = 'AK: Our Clients', $widget_ops, $control_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => '', 'desc' => '', 'number' => '5', 'path0' => '', 'path1' => '', 'path2' => '', 'path3' => '', 'path4' => '', 'redirect_link0' => '', 'redirect_link1' => '', 'redirect_link2' => '', 'redirect_link3' => '', 'redirect_link4' => '',
            'c_name0' => '', 'c_name1' => '', 'c_name2' => '', 'c_name3' => '', 'c_name4' => ''));

        $number = absint($instance['number']);
        ob_start();
        ?>
        <p class="description">
            Note: Recommended size for the image is 400px (width) and 150px (height). If you want more image adding
            fields then first enter the number and click on Save.
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['title'])); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('desc'); ?>">Description :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['desc'])); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"> Number of Images:</label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="5"/>
        </p>
        <hr>
        <?php
        for ($i = 0; $i < $number; $i++) {
            $path = 'path' . $i;
            $url = 'redirect_link' . $i;
            $c_name = 'c_name' . $i;
            ?>
            <p>
                <label>Company Name:</label>
                <input placeholder="Client name" class="widefat" name="<?php echo $this->get_field_name($c_name); ?>" type="text" value="<?php if (isset ($instance[$c_name])) echo esc_attr($instance[$c_name]); ?>"/>
            </p>
            <p>
                <input class="img_url" size="20" placeholder="Image url" type="text" name="<?php echo $this->get_field_name($path); ?>" value="<?php if (isset ($instance[$path])) echo esc_url($instance[$path]); ?>"/>
                <input class="button ank_upload_image" type="button" value="<?php echo __('Upload'); ?>"/>
            </p>
            <p>
                <label>Redirect Link:</label>
                <input placeholder="Client url" class="widefat" name="<?php echo $this->get_field_name($url); ?>" type="text" value="<?php if (isset ($instance[$url])) echo esc_url($instance[$url]); ?>"/>
            </p>
            <hr>
        <?php } ?>
        <?php
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['desc'] = esc_textarea($new_instance['desc']);
        $instance['number'] = absint($new_instance['number']);

        for ($i = 0; $i < $instance['number']; $i++) {
            $path = 'path' . $i;
            $url = 'redirect_link' . $i;
            $c_name = 'c_name' . $i;
            $instance[$path] = esc_url_raw($new_instance[$path]);
            $instance[$url] = esc_url_raw($new_instance[$url]);
            $instance[$c_name] = esc_attr($new_instance[$c_name]);
        }
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = $instance['title'];
        $desc = esc_html($instance['desc']);
        $number = empty($instance['number']) ? 5 : absint($instance['number']);
        $path_array = array();
        $url_array = array();
        $name_array = array();

        for ($i = 0; $i < $number; $i++) {

            $path = isset($instance['path' . $i]) ? $instance['path' . $i] : '';
            $redirect_link = isset($instance['redirect_link' . $i]) ? $instance['redirect_link' . $i] : '';
            $c_name = isset($instance['c_name' . $i]) ? $instance['c_name' . $i] : '';
            if (!empty($path) || !empty($redirect_link) || !empty($c_name)) {
                if (!empty($path)) {
                    array_push($path_array, $path);
                } else {
                    array_push($path_array, "");
                }
                if (!empty($redirect_link)) {
                    array_push($url_array, $redirect_link);
                } else {
                    array_push($url_array, "");
                }
                if (!empty($c_name)) {
                    array_push($name_array, $c_name);
                } else {
                    array_push($name_array, "");
                }
            }
        }

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        if (!empty($desc)) {
            echo '<p>' . $desc . '</p>';
        }

        if (!empty($path_array)) {
            $output = '';
            $output .= '<ul>';
            for ($i = 0; $i < $number; $i++) {
                if (!empty($url_array[$i]) || !empty($path_array[$i])) {
                    $output .= '<li >';
                    $output .= '<a href="' . $url_array[$i] . '" title="' . $name_array[$i] . '" target="_blank">
						<img src="' . $path_array[$i] . '" alt="' . $name_array[$i] . '">
						</a>';
                    $output .= '</li>';
                }
            }
            $output .= '</ul>';
            echo $output;
        }

        echo $args['after_widget'];
    }

}


class ank_floating_form_widget extends WP_Widget
{
    //need contact form 7, font awesome + custom css  + no external js
    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_floating_form', 'description' => 'Floating Form');
        $control_ops = array('width' => 250, 'height' => 350);
        parent::__construct('widget_floating_form', 'AK: Floating Form', $widget_ops, $control_ops);
    }

    public function widget($args, $instance)
    {
        $title = empty($instance['title']) ? 'Click Here' : esc_html($instance['title']);
        $icon = empty($instance['icon']) ? 'fa-envelope' : sanitize_html_class($instance['icon']);
        $text = apply_filters('widget_text', empty($instance['text']) ? '' : $instance['text'], $instance);
        $class_btn = '';
        $class_frm = '';
        if ($instance['left']) {
            $class_btn = ' float-btn-left';
            $class_frm = ' floating-form-left';
        }
        ob_start();
        echo $args['before_widget'];
        ?>
        <div class="float-btn <?php echo $class_btn; ?>">
            <div onclick="var el=this.parentNode;el.nextElementSibling.style.display = 'block';el.style.display = 'none';" title="<?php echo $title; ?>">
                <i class="fa <?php echo $icon; ?> fa-rotate-90"> </i>
                <span><?php echo $title; ?></span></div>
        </div>
        <div class="floating-form <?php echo $class_frm; ?>" style="display: none" aria-haspopup="true">
            <span title="Close" class="close-btn" onclick="var ll=this.parentNode;ll.style.display = 'none';ll.previousElementSibling.style.display = 'block';"><i class="fa fa-times-circle"></i></span>
            <?php echo $text; //no escape html ?>
        </div>
        <?php
        echo $args['after_widget'];
        //strip white space
        echo preg_replace('/(\s)+/s', '\\1', ob_get_clean());
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['icon'] = strip_tags($new_instance['icon']);
        if (current_user_can('unfiltered_html'))
            $instance['text'] = $new_instance['text'];
        else
            $instance['text'] = stripslashes(wp_filter_post_kses(addslashes($new_instance['text'])));
        $instance['left'] = isset($new_instance['left']);
        return $instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => '', 'icon' => '', 'text' => ''));
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Button Text:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['title'])); ?>"/>
        </p>
        <p><label for="<?php echo $this->get_field_id('icon'); ?>">Icon Class:</label>
            <input placeholder="fa-envelope" class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" name="<?php echo $this->get_field_name('icon'); ?>" type="text" value="<?php echo esc_attr(strip_tags($instance['icon'])); ?>"/>
        </p>
        <label>Contact form 7 Short-code:(Html Allowed)</label>
        <textarea placeholder="Short-code" class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea($instance['text']) ?></textarea>
        <p><input id="<?php echo $this->get_field_id('left'); ?>" name="<?php echo $this->get_field_name('left'); ?>"
                  type="checkbox" <?php checked(isset($instance['left']) ? $instance['left'] : 0); ?> />&nbsp;
            <label for="<?php echo $this->get_field_id('left'); ?>">Float in left (default:right)</label>
        </p>
    <?php
    }
}

class Ank_Social_Menu_Widget extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array('classname' => 'widget_social_nav', 'description' => 'Social menu with icons.');
        parent::__construct('widget_social_nav', 'AK: Social Menu', $widget_ops);
    }

    public function widget($args, $instance)
    {
        // Get menu
        $nav_menu = !empty($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : false;
        //return if menu not found
        if (!$nav_menu)
            return;

        echo $args['before_widget'];
        if (!empty($instance['title']))
            echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

        wp_nav_menu(array('fallback_cb' => '', 'menu' => $nav_menu, 'container' => false,
            'menu_class' => 'social-nav ',
            'depth' => -1, //flat list only
            'link_before' => '<span class="screen-reader-text">',
            'link_after' => '</span>',));

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags(stripslashes($new_instance['title']));
        $instance['nav_menu'] = (int)$new_instance['nav_menu'];


        return $instance;
    }

    public function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => '', 'nav_menu' => ''));
        $nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';
        // Get menus
        $menus = wp_get_nav_menus();
        // If no menus exists, direct the user to go and create some.
        if (!$menus) {
            echo '<p>' . sprintf(__('No menus have been created yet. <a href="%s">Create some</a>.'), admin_url('nav-menus.php')) . '</p>';
            return;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:') ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_html($instance['title']) ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
            <select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
                <option value="0"><?php _e('&mdash; Select &mdash;') ?></option>
                <?php
                foreach ($menus as $menu) {
                    echo '<option value="' . $menu->term_id . '"'
                        . selected($nav_menu, $menu->term_id, false)
                        . '>' . esc_html($menu->name) . '</option>';
                }
                ?>
            </select>
        </p>
    <?php
    }
}

?>