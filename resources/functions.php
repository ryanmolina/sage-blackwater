<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'sage');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'sage'), __('Invalid PHP version', 'sage'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'sage'), __('Invalid WordPress version', 'sage'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__ . '/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'sage'),
            __('Autoloader not found.', 'sage')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
    ->bindIf('config', function () {
        return new Config([
            'assets' => require dirname(__DIR__) . '/config/assets.php',
            'theme' => require dirname(__DIR__) . '/config/theme.php',
            'view' => require dirname(__DIR__) . '/config/view.php',
        ]);
    }, true);

/**
 *  Custom Post-Type
 */
add_action('init', function () {
    $types = array(
        array(
            'type' => 'cottage',
            'singular' => 'Cottage',
            'plural' => 'Cottages',
        ),
        array(
            'type' => 'room',
            'singular' => 'Room',
            'plural' => 'Rooms',
        ),
    );

    foreach ($types as $t) {
        $type = $t['type'];
        $singular = $t['singular'];
        $plural = $t['plural'];

        $labels = array(
            'name' => $plural,
            'singular_name' => $singular,
            'add_new' => 'Add New',
            'add_new_item' => 'Add New',
            'edit_item' => 'Edit',
            'new_item' => 'New',
            'view_item' => 'View',
            'search_item' => 'Search',
            'not_found' => 'No ' . $plural . ' found',
            'not_found_in_trash' => 'No ' . $plural . ' in trash',
            'parent_item_colon' => '',
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archives' => false,
            'menu_icon' => 'dashicons-laptop',
            'publicly_queryable' => true,
            'query_var' => true,
            'shows_in_nav_menus' => true,
            'rewrite' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ),
            'menu_position' => 5,
        );
        register_post_type($type, $args);
    }
});

add_action('admin_menu', function () {
    remove_meta_box('authordiv', 'cottage', 'normal');
    remove_meta_box('commentstatusdiv', 'cottage', 'normal');
    remove_meta_box('commentsdiv', 'cottage', 'normal');
    remove_meta_box('postcustom', 'cottage', 'normal');
    remove_meta_box('postexcerpt', 'cottage', 'normal');
    remove_meta_box('revisionsdiv', 'cottage', 'normal');
    remove_meta_box('slugdiv', 'cottage', 'normal');
    remove_meta_box('trackbacksdiv', 'cottage', 'normal');
    remove_meta_box('editor', 'cottage', 'normal');
    remove_post_type_support( 'cottage', 'editor' );
});

function show_upload_image_meta_box() {
    global $post;
    $meta_box_value = get_post_meta($post->ID, 'upload_image', true);
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    echo '<input id="upload_image" type="text" size="36" name="upload_image" value="'.$meta_box_value.'"/>
          <input id="upload_image_button" type="button" value="Upload Image" />
          <div>
            <img id="upload_image_preview" src="'.$meta_box_value.'" onerror="this.style.display=none" style="max-width: 480px">
          </div>';
}

add_action('add_meta_boxes', function () {
    add_meta_box(
        'cottage-upload_image',
        'Image',
        'show_upload_image_meta_box',
        'cottage'
    );
});


function save_cottage ($post_id) {
    if (!isset($_POST['custom_meta_box_nonce'])) return;

    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type'] || 'post' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
    save_custom_meta_data($post_id, 'upload_image');
}
add_action('save_post', 'save_cottage');


function save_custom_meta_data($post_id, $field_id) {
    $old = get_post_meta($post_id, $field_id, true);
    $new = $_POST[$field_id];
    if ($new && $new != $old) {
        update_post_meta($post_id, $field_id, $new);
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, $field_id, $old); 
    }
}

add_action('add_meta_boxes', function () {
    global $post;

    if ( ! empty($post) ) {
        $template = get_post_meta($post->ID, '_wp_page_template', true);
        if ($template == 'views/template-grid.blade.php') {
            add_meta_box(
                'selected_post_type_meta',
                'Post type to display',
                'show_post_type_radio_button',
                'page',
                'normal',
                'high'
            );
        } 
    }
});

function show_post_type_radio_button () {
    global $post;
    $meta_box_value = get_post_meta($post->ID, 'selected_cpt', true);
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    echo '
        <fieldset id="post_type_radio_button">
            <div>
                <input id="selected_cpt" type="radio" value="cottage" name="selected_cpt" '.($meta_box_value == 'cottage' ? 'checked' : '').'>
                <label>Cottage</label>
            </div>
            <div>
                <input id="selected_cpt" type="radio" value="room" name="selected_cpt" '.($meta_box_value == 'room' ? 'checked' : '').'>
                <label>Room</label>
            </div>
        </fieldset>
    ';
 }

function save_selected_cpt ($post_id) {
    if (!isset($_POST['custom_meta_box_nonce'])) return;

    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type'] || 'post' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
    }
    save_custom_meta_data($post_id, 'selected_cpt');
}
add_action('save_post', 'save_selected_cpt');