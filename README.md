This package is intened to be installed in the WordPress root and loaded via `autoload.php` so WordPress plays nicely with `php -S`.

# Installation & Use

```bash
composer require aubreypwd/php-s-wp
```

Then in your `wp-config.php` make sure and require `autoload.php` e.g.:

```php
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}
```

# Fixes accessing e.g. `/wp-admin` w/out trailing slash

Now you can start up `php -S` in your WordPress root and places like `http://localhost:8000/wp-admin` will be automatically re-directed to `http://localhost:8000/wp-admin/` so things don't break.
