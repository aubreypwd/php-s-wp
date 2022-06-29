<?php
/**
 * Fix problem when accessing e.g. /wp-admin which breaks vs accessing
 * /wp-admin/.
 *
 * This automatically re-directs e.g. /wp-admin to /wp-admin/ so pages work.
 *
 * @since 1.0.0
 */

if ( defined( 'WP_CLI' ) ) {

	// Ignore WP CLI.
	return;
}

// Yes, put these in a place where they won't be in the way of WordPress.
$_GLOBALS['php-s-wp']['directory-slash-fix']['parsed']    = parse_url( isset( $_SERVER["REQUEST_URI"] ) ? $_SERVER["REQUEST_URI"] : '' );
$_GLOBALS['php-s-wp']['directory-slash-fix']['query']     = isset( $_GLOBALS['php-s-wp']['directory-slash-fix']['parsed']['query'] ) ? "{$_GLOBALS['php-s-wp']['directory-slash-fix']['parsed']['query']}" : '';
$_GLOBALS['php-s-wp']['directory-slash-fix']['path']      = isset( $_GLOBALS['php-s-wp']['directory-slash-fix']['parsed']['path'] ) ? "{$_GLOBALS['php-s-wp']['directory-slash-fix']['parsed']['path']}" : '';
$_GLOBALS['php-s-wp']['directory-slash-fix']['doc_root']  = isset( $_SERVER['DOCUMENT_ROOT'] ) ? $_SERVER['DOCUMENT_ROOT'] : '';
$_GLOBALS['php-s-wp']['directory-slash-fix']['real_path'] = rtrim( $_GLOBALS['php-s-wp']['directory-slash-fix']['doc_root'], '/' ) . '/' . ltrim( $_GLOBALS['php-s-wp']['directory-slash-fix']['path'], '/' );

if (
	empty( $_GLOBALS['php-s-wp']['directory-slash-fix']['doc_root'] ) ||
	empty( $_GLOBALS['php-s-wp']['directory-slash-fix']['path'] )
) {
	return; // No need to redirect w/out these.
}

// Enforce trailing slash on directories because php -S is weird.
if (

	// For it to be a directory, it has to exist.
	file_exists( $_GLOBALS['php-s-wp']['directory-slash-fix']['real_path'] ) &&

	// If you aren't requesting a direct file (it must be a directory or pretty permalink)...
	! is_file( $_GLOBALS['php-s-wp']['directory-slash-fix']['real_path'] ) &&

	// And it does not have a trailing slash...
	'/' !== $_GLOBALS['php-s-wp']['directory-slash-fix']['path'][-1]
) {

	if ( ! empty( $_GLOBALS['php-s-wp']['directory-slash-fix']['query'] ) ) {

		// Add the trailing slash w/ the query.
		header( "Location: {$_GLOBALS['php-s-wp']['directory-slash-fix']['path']}/?{$_GLOBALS['php-s-wp']['directory-slash-fix']['query']}");
		exit;
	}

	// Add the trailing slash (no query).
	header( "Location: {$_GLOBALS['php-s-wp']['directory-slash-fix']['path']}/");
	exit;
}

unset( $_GLOBALS['php-s-wp'] );