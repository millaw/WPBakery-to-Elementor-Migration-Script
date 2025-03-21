<?php
/**
 * Plugin Name: WPBakery to Elementor Migration
 * Description: Converts WPBakery shortcodes into Elementor widgets.
 * Version: 1.0
 * Author: Milla Wynn
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Add an admin menu item to run the migration
add_action('admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'WPBakery to Elementor Migration',
        'WPBakery to Elementor',
        'manage_options',
        'wpbakery-to-elementor',
        'wpbakery_to_elementor_page'
    );
});

function wpbakery_to_elementor_page() {
    echo '<div class="wrap">';
    echo '<h2>WPBakery to Elementor Migration</h2>';
    if (isset($_POST['migrate_content'])) {
        wpbakery_to_elementor_convert();
    }
    echo '<form method="post">';
    echo '<input type="submit" name="migrate_content" value="Start Migration" class="button button-primary">';
    echo '</form>';
    echo '</div>';
}

// Function to convert WPBakery shortcodes to Elementor widgets
function wpbakery_to_elementor_convert() {
    global $wpdb;

    $posts = $wpdb->get_results("SELECT ID, post_content FROM {$wpdb->posts} WHERE post_type IN ('page', 'post')", ARRAY_A);

    foreach ($posts as $post) {
        $content = $post['post_content'];

        // Remove WPBakery row/column wrappers (Elementor handles layout differently)
        $content = str_replace(['[vc_row]', '[/vc_row]', '[vc_column]', '[/vc_column]'], '', $content);
        
        // Convert WPBakery Text Blocks to Elementor Text Editor Widgets
        $content = preg_replace('/\[vc_column_text\](.*?)\[\/vc_column_text\]/s', '<!-- wp:paragraph -->\1<!-- /wp:paragraph -->', $content);

        // Convert WPBakery Single Images to Elementor Image Widgets
        $content = preg_replace_callback('/\[vc_single_image image="(\d+)"[^\]]*\]/', function ($matches) {
            $image_url = wp_get_attachment_url($matches[1]);
            return '<!-- wp:image {"url":"' . esc_url($image_url) . '"} --><img src="' . esc_url($image_url) . '" /><!-- /wp:image -->';
        }, $content);

        // Convert WPBakery Buttons to Elementor Button Widgets
        $content = preg_replace('/\[vc_btn title="(.*?)" link="(.*?)"[^\]]*\]/', '<!-- wp:button --><a href="\2">\1</a><!-- /wp:button -->', $content);

        // Convert WPBakery Heading to Elementor Heading Widgets
        $content = preg_replace('/\[vc_custom_heading text="(.*?)" font_size="(.*?)px"[^\]]*\]/', '<!-- wp:heading --><h2 style="font-size:\2px;">\1</h2><!-- /wp:heading -->', $content);

        // Update the post content in the database
        $wpdb->update(
            $wpdb->posts,
            ['post_content' => $content],
            ['ID' => $post['ID']],
            ['%s'],
            ['%d']
        );

        // Clear cache for updated pages
        clean_post_cache($post['ID']);
    }

    echo '<div class="updated"><p>Migration Completed. WPBakery shortcodes have been converted to Elementor-compatible content.</p></div>';
}
