<?php


function citys_post_types(){

	$labels = array(
		'name' => 'Cities',
		'singular_name' => 'Cities',
		'menu_name' => 'Cities',
		'all_items' => 'All Cities',
		'add_new' => 'Add Citie',
		'add_new_item' => 'Add New Citie',
		'edit_item' => 'Edit Citie',
		'new_item' => 'New Citie',
		'view_item' => 'View Citie',
		'search_items' => 'Find Citie',
		'not_found' => 'Citie not found',
		'not_found_in_trash' => 'В корзине Города не найдены',
	);
	register_post_type( 'citys',
		array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'query_var' => true,
			'show_ui' => true,
			'menu_position' => 12,
			'menu_icon' => 'dashicons-admin-multisite',
			//'taxonomies' => array('post_tag'),
			'supports' => array( 'title', 'editor', 'thumbnail','excerpt'),
			'has_archive' => true,
			'capability_type' => 'post',
			'rewrite' => array( 'slug' => 'cities','with_front' => FALSE),
			'show_in_nav_menus' => true,
		)
	);



	//-----------------------------------------------------------------------------------------------------
}

add_action( 'init', 'citys_post_types' );

//flush_rewrite_rules(); //first stert
