<?php
/*
 * Theme option panel for our theme
 * We don't need any Option Framework , using wp inbuilt Theme setting API
 *
 */
add_action('customize_register', 'corpo_customize_register', 11);

function corpo_customize_register($wp_customize)
{

    global $wp_customize;

    //add our separate panel
    $wp_customize->add_panel('corpo_panel', array(
        'priority' => 180,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => '◈ Theme Options',
        'description' => 'Theme Options by- Ank91',
    ));
    // Add Section for Theme Options
    $wp_customize->add_section('header_section', array(
            'title' => 'Header Settings',
            'priority' => 10,
            'panel' => 'corpo_panel'
        )
    );

    $wp_customize->add_setting('corpo_theme_options[logo_image]', array(
        'default' => '',
        'type' => 'option',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'corpo_theme_options[logo_image]', array(
        'description' => 'Suggested image Size: 200x75',
        'label' => 'Upload Logo',
        'section' => 'header_section',

    )));
    $wp_customize->add_setting('corpo_theme_options[logo_opt]', array(
        'default' => '2',
        'type' => 'option',
    ));

    $wp_customize->add_control('corpo_theme_options[logo_opt]', array(
        'label' => 'Logo Options',
        'section' => 'header_section',
        'sanitize_callback' => 'corpo_sanitize_select_box',
        'type' => 'select',
        'choices' => array(
            '1' => 'Logo Only',
            '2' => 'Heading Only',
            '3' => 'Show Both')

    ));
    //header section ends here

    //layout section starts
    $wp_customize->add_section('layout_section', array(
            'title' => 'Layout Settings',
            'priority' => 11,
            'panel' => 'corpo_panel'
        )
    );
    $wp_customize->add_setting('corpo_theme_options[layout]', array(
        'default' => '2',
        'type' => 'option',
    ));

    $wp_customize->add_control('corpo_theme_options[layout]', array(
        'label' => 'Select default layout',
        'section' => 'layout_section',
        'type' => 'radio',
        'choices' => array(
            '1' => 'Left Sidebar',
            '2' => 'Right Sidebar',
        ),
    ));

    //additional start
    $wp_customize->add_section('additional_section', array(
            'title' => 'Additional Settings',
            'priority' => 13,
            'panel' => 'corpo_panel'
        )
    );
    $wp_customize->add_setting('corpo_theme_options[favicon]', array(
        'default' => '',
        'type' => 'option',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'corpo_theme_options[favicon]', array(
        'description' => 'Must be .png (16x16)<br>Remove image to disable',
        'label' => 'Upload Favicon Image',
        'section' => 'additional_section',
    )));
    //additional sections ends

    //slider section start
    $wp_customize->add_section('slider_section', array(
            'title' => '✱ Slider Settings',
            'description' => 'Recommended size is 1366x500 (pixel)',
            'priority' => 12,
            'panel' => 'corpo_panel',
        )
    );
    $wp_customize->add_setting('corpo_theme_options[slide_meta_off]', array(
        'default' => '',
        'type' => 'option',
    ));
    $wp_customize->add_control('corpo_theme_options[slide_meta_off]', array(
        'label' => 'Completely Disable Slider meta',
        'section' => 'slider_section',
        'type' => 'checkbox',
    ));
    //supports 5 slides
    for ($i = 0; $i <= 4; $i++) {
        $j = $i + 1;
        $wp_customize->add_setting("corpo_theme_options[slide_img][$i]", array(
            'default' => '',
            'type' => 'option',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "corpo_theme_options[slide_img][$i]", array(
            'label' => 'Upload Slide Image- ' . $j,
            'section' => 'slider_section',

        )));
        $wp_customize->add_setting("corpo_theme_options[slide_head][$i]", array(
            'default' => '',
            'type' => 'option',

        ));
        $wp_customize->add_control("corpo_theme_options[slide_head][$i]", array(
            'label' => '',
            'description' => 'Slide Heading',
            'section' => 'slider_section',
            'type' => 'text',

        ));
        $wp_customize->add_setting("corpo_theme_options[slide_desc][$i]", array(
            'default' => '',
            'type' => 'option',
        ));
        $wp_customize->add_control("corpo_theme_options[slide_desc][$i]", array(
            'label' => '',
            'description' => 'Slide Bottom Line',
            'section' => 'slider_section',
            'type' => 'text',

        ));
        $wp_customize->add_setting("corpo_theme_options[slide_btn][$i]", array(
            'default' => '',
            'type' => 'option',
        ));
        $wp_customize->add_control("corpo_theme_options[slide_btn][$i]", array(
            'label' => '',
            'description' => 'Slide Button Text',
            'section' => 'slider_section',
            'type' => 'text',

        ));
        $wp_customize->add_setting("corpo_theme_options[slide_url][$i]", array(
            'default' => '',
            'type' => 'option',
        ));
        $wp_customize->add_control("corpo_theme_options[slide_url][$i]", array(
            'label' => '',
            'description' => 'Slide Button URL',
            'section' => 'slider_section',
            'type' => 'url',


        ));
    }//end for loop
}

//this function will be used to retrieve theme option in templates
function get_corpo_option($name, $default = false)
{
    $options = (get_option('corpo_theme_options')) ? get_option('corpo_theme_options') : null;
    // return the option if it exists
    if (isset($options[$name])) {
        return $options[$name];
    }
    // return default if nothing else
    return $default;

}

//set default options // be fail safe
add_action('after_setup_theme', 'set_corpo_default_options');

function set_corpo_default_options()
{
    //return early if options exists
    if (get_option('corpo_theme_options'))
        return;
    //else store default if no setting exists
    update_option('corpo_theme_options', array(
        'favicon' => '',
        'logo_image' => '',
        'logo_opt' => '2',
        'layout' => '2',
        'post_img' => '2',
        'slide_img' => array('', '', '', '', ''), //quick fix
        'slide_head' => array('', '', '', '', ''),
        'slide_desc' => array('', '', '', '', ''),
        'slide_btn' => array('', '', '', '', ''),
        'slide_url' => array('', '', '', '', ''),
    ));
}

/** Sanitize the select options, we can add sanitize to all settings */
function corpo_sanitize_select_box($input)
{

    return intval($input);

}

