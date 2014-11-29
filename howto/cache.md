# Syllables: Caching HOWTO

## Fragment caching

Fragment caching stores and reuses previously rendered HTML snippets that are expensive to generate.  Simply wrap the example structure below around your existing code to cache its output and speed things up a bit.

### Usage

```php
$fragment = new \Syllables\Cache\Fragment( 'unique-key', 3600 );

if ( ! $fragment->output() ) {
    // Your code goes here. It should output a result, otherwise
    // nothing will be cached.

    // IMPORTANT! DO NOT FORGET THIS:
    $fragment->store();
}
```
