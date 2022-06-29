<?php
/**
 * Fix problem when accessing e.g. /wp-admin which breaks vs accessing
 * /wp-admin/.
 *
 * This automatically re-directs e.g. /wp-admin to /wp-admin/ so pages work.
 *
 * @since 1.0.0
 */

// Enforce trailing slash on directories because php -S is weird.
if (

	// Ignore WP CLI.
	! defined( 'WP_CLI' ) &&

	// If it's a directory you're calling...
	isset( $_SERVER["REQUEST_URI"] ) &&
	is_dir( __DIR__ . $_SERVER["REQUEST_URI"] ) &&

	// And it does not have a trailing slash...
	'/' !== $_SERVER["REQUEST_URI"][-1]
) {

	// Re-direct to the directory with a trailing slash.
	header( "Location: {$_SERVER["REQUEST_URI"]}/");
	exit;
}