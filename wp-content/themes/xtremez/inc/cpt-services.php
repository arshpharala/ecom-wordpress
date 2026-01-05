<?php
if (!defined('ABSPATH')) exit;

add_action('init', function () {

  $labels = [
    'name'               => 'Services',
    'singular_name'      => 'Service',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Service',
    'edit_item'          => 'Edit Service',
    'new_item'           => 'New Service',
    'view_item'          => 'View Service',
    'search_items'       => 'Search Services',
    'not_found'          => 'No services found',
    'not_found_in_trash' => 'No services found in Trash',
    'menu_name'          => 'Services',
  ];

  register_post_type('service', [
    'labels'             => $labels,
    'public'             => true,
    'show_in_rest'       => true,
    'has_archive'        => true,
    'menu_position'      => 20,
    'menu_icon'          => 'dashicons-admin-tools',
    'supports'           => ['title', 'editor', 'excerpt', 'thumbnail'],
    'rewrite'            => ['slug' => 'services'],
  ]);
});
