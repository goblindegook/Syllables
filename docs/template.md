# Templates

## Taxonomy Templates

```php
$base_path  = plugin_dir( __FILE__ ) . 'templates';
$taxonomies = array( '__taxonomy__' );

new \Syllables\Template\Loader\Taxonomy( $base_path, $taxonomies );
```

## Post Type Archive Templates

```php
$base_path  = plugin_dir( __FILE__ ) . 'templates';
$post_types = array( '__post-type__' );

new \Syllables\Template\Loader\Post_Type_Archive( $base_path, $post_types );
```

## Single Post Templates

```php
$base_path  = plugin_dir( __FILE__ ) . 'templates';
$post_types = array( '__post-type__' );

new \Syllables\Template\Loader\Single( $base_path, $post_types );
```
