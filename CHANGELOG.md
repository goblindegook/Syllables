# Change Log

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](http://semver.org/).

## [0.3.2] - July 18, 2015
- **[Added]** Shortcode `syllables/shortcode/output` filter.
- **[Fixed]** Allow shortcode callback to receive the calling tag name as a parameter.
- **[Deprecated]** Shortcode `syllables/shortcode/render` filter.

## [0.3.1] – February 13, 2015
- **[Added]** Shortcode tag name accessor.
- **[Fixed]** Shortcode wrapper support for content enclosed in tags.

## [0.3.0] – February 10, 2015
- **[Changed]** Package installs as a WordPress plugin by default.
- **[Added]** Shortcode wrapper and `syllables/shortcode/render` output filter.
- **[Added]** Support for `composer/installers`.

## [0.2.0] – January 22, 2015
- **[Added]** Allow templates in the `single-{{post type}}-{{slug}}.php` format.
- **[Added]** Fragment cache flushing.
- **[Fixed]** Empty and `0` strings are now properly cached by the fragment cache.
- **[Fixed]** Dependencies no longer require PHP 5.4.

## 0.1.0 – December 7, 2014
- Initial release.
- **[Added]** Fragment caching.
- **[Added]** Template loader for post type and taxonomy archives, as well as single posts.
- **[Added]** `WP_Error` exception wrapper.

[unreleased]: https://github.com/goblindegook/Syllables/compare/0.3.1...HEAD
[0.3.1]: https://github.com/goblindegook/Syllables/compare/0.3.0...0.3.1
[0.3.0]: https://github.com/goblindegook/Syllables/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/goblindegook/Syllables/compare/0.1.0...0.2.0
