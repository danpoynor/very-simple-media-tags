<?php
/*
Plugin Name: Very Simple Media Tags
Description: This plugin adds a tags taxonomy for Media files.
Version: 1.0
Author: Dan Poynor
*/

function vsmtags_add_media_tags() {
    $taxonomies = array('post_tag');
    foreach($taxonomies as $tax) {
        register_taxonomy_for_object_type($tax, 'attachment');
    }
}
add_action('init', 'vsmtags_add_media_tags');

// Add a Tags column to the Media Library list view
function vsmtags_add_tags_column($columns) {
    $columns['tags'] = 'Tags';
    return $columns;
}
add_filter('manage_media_columns', 'vsmtags_add_tags_column');

// Display the tags in the Tags column
function vsmtags_display_tags_column($column_name, $post_id) {
    if ($column_name === 'tags') {
        $tags = wp_get_object_terms($post_id, 'post_tag');
        if (!empty($tags)) {
            if (!is_wp_error($tags)) {
                $tag_names = array();
                foreach ($tags as $tag) {
                    $tag_names[] = $tag->name;
                }
                echo implode(', ', $tag_names);
            }
        }
    }
}
add_action('manage_media_custom_column', 'vsmtags_display_tags_column', 10, 2);