# Templates

## Taxonomy Templates

Lets you to override a theme template for a taxonomy by attempting to load one of the following files in your specified directory:

* `taxonomy-{{taxonomy}}-{{term}}.php`
* `taxonomy-{{taxonomy}}.php`

### Usage

```php
$base_path  = plugin_dir_path( __FILE__ ) . 'templates';
$taxonomies = array( '__taxonomy__' );

new \Syllables\Template\Loader\Taxonomy( $base_path, $taxonomies );
```

## Post Type Archive Templates

Lets you to override a theme template for a post type archive by attempting to load the following file in your specified directory:

* `archive-{{post type}}.php`

### Usage

```php
$base_path  = plugin_dir_path( __FILE__ ) . 'templates';
$post_types = array( '__post-type__' );

new \Syllables\Template\Loader\Post_Type_Archive( $base_path, $post_types );
```

## Single Post Templates

Lets you to override a single post template for a post type by attempting to load the following file in your specified directory:

* `single-{{post type}}.php`

### Usage

```php
$base_path  = plugin_dir_path( __FILE__ ) . 'templates';
$post_types = array( '__post-type__' );

new \Syllables\Template\Loader\Single( $base_path, $post_types );
```
