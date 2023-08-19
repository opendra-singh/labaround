<?php

/**
 * Plugin Name: WooDevz Customization
 * Plugin URI: https://woodevz.com
 * Description: A simple Customization from WooDevz.
 * Version: 1.0.0
 * Author: WooDevz Technologies
 * Author URI: https://woodevz.com
 */

function enqueue_assets()
{
	wp_enqueue_script("wd-public", plugin_dir_url(__FILE__) . "js/wd_public.js", array('jquery'));
	wp_enqueue_style("woodevz-public", plugin_dir_url(__FILE__) . "css/wd_public.css");
}

function admin_assets()
{
	global $current_user;
	wp_enqueue_script("wd-admin", plugin_dir_url(__FILE__) . "js/wd_admin.js", array('jquery'));
	wp_enqueue_style("woodevz-admin", plugin_dir_url(__FILE__) . "css/wd_admin.css");
	wp_localize_script('wd-admin', 'currentUserData', array('userRole' => $current_user->roles[0]));
}

function add_custom_account_menu_item($items)
{
	// Check if the current user is a customer
	if (in_array('customer', wp_get_current_user()->roles)) {
		// Add your custom menu item to the existing items array
		$custom_item = array(
			'Wishlist' => 'Wish List'
		);

		// Find the position of the 'customer-logout' menu item
		$logout_position = array_search('customer-logout', array_keys($items));

		// Insert the custom menu item above the logout link
		if ($logout_position !== false) {
			$items = array_slice($items, 0, $logout_position, true) + $custom_item + array_slice($items, $logout_position, null, true);
		} else {
			// If the logout link is not found, add the custom item to the end
			$items += $custom_item;
		}
	}
	return $items;
}

function check_user_log()
{
	?><input type="hidden" id="woodevz-user-login" value="<?= is_user_logged_in() ? "yes" : "no" ?>"><?php
}

function change_user_role_capabilities()
{
	try {

		$capabilities = [
			"moderate_comments",
			"manage_categories",
			"manage_links",
			"upload_files",
			"unfiltered_html",
			"edit_posts",
			"edit_others_posts",
			"edit_published_posts",
			"publish_posts",
			"edit_pages",
			"read",
			"level_7",
			"level_6",
			"level_5",
			"level_4",
			"level_3",
			"level_2",
			"level_1",
			"level_0",
			"edit_others_pages",
			"edit_published_pages",
			"publish_pages",
			"delete_pages",
			"delete_others_pages",
			"delete_published_pages",
			"delete_posts",
			"delete_others_posts",
			"delete_published_posts",
			"delete_private_posts",
			"edit_private_posts",
			"read_private_posts",
			"delete_private_pages",
			"edit_private_pages",
			"read_private_pages",
			"rank_math_site_analysis",
			"rank_math_onpage_analysis",
			"rank_math_onpage_general",
			"rank_math_onpage_snippet",
			"rank_math_onpage_social",
			"manage_capabilities_dashboard",
			"manage_capabilities_roles",
			"manage_capabilities",
			"manage_capabilities_editor_features",
			"manage_capabilities_admin_features",
			"manage_capabilities_admin_menus",
			"manage_capabilities_profile_features",
			"manage_capabilities_nav_menus",
			"manage_capabilities_user_testing",
			"manage_capabilities_backup",
			"manage_capabilities_settings",
			"manage_product",
			"edit_comments",
		];

		// Get the WP_Role object for the specified role.
		$wp_role = get_role("editor");
		if ($wp_role !== null) {
			foreach ($capabilities as $single) {
				// Add a new capability to the role.
				$wp_role->add_cap($single);
			}
		}
		// Get the WP_Role object for the specified role.
		$wp_role = get_role("author");
		if ($wp_role !== null) {
			foreach ($capabilities as $single) {
				// Add a new capability to the role.
				$wp_role->add_cap($single);
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}

function redirect_on_logout()
{
	if (!is_user_logged_in()) {
		global $wp;
		$current_url = home_url(add_query_arg(array(), $wp->request));
		if (str_contains($current_url, "wishlist")) {
			wp_safe_redirect(home_url('my-account'));
		}
	}
}

add_action("wp_enqueue_scripts", "enqueue_assets");
add_action("admin_enqueue_scripts", "admin_assets");
add_action("wp_footer", "check_user_log");
add_action('init', 'change_user_role_capabilities');
add_action('wp', 'redirect_on_logout');

add_filter('woocommerce_account_menu_items', 'add_custom_account_menu_item');
