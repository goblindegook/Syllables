# Syllables: Exceptions HOWTO

## Throwing a `WP_Error` object as an exception

Lets you throw a `WP_Error` instance inside an exception.

### Usage

```php
use \Syllables\Exception;

$result = function_which_may_return_wp_errors();

if ( is_wp_error( $result ) ) {
    throw new WP_Exception( null, null, $result );
}
```

## Obtaining a `WP_Error` object from a caught exception

Lets you reclaim the original `WP_Error` instance (or obtain a new one) from an exception.

### Usage

```php
use \Syllables\Exception;

try {
    // Code that throws a \WP_Exception
} catch ( \WP_Exception $wp_exception ) {
    $wp_error = $wp_exception->get_wp_error();
}
```
