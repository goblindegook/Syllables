# Syllables

Syllables are helper classes and functions for WordPress development.

[![Build Status](https://travis-ci.org/goblindegook/Syllables.svg?branch=master)](https://travis-ci.org/goblindegook/Syllables) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/goblindegook/Syllables/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/goblindegook/Syllables/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/goblindegook/Syllables/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/goblindegook/Syllables/?branch=master)

## Installation

### In your projects using Composer

To install this library as a dependency in your project using [Composer](https://getcomposer.org/), run the following command to get the latest version:

```
$ composer require goblindegook/syllables
```

Besides downloading the required libraries, Composer also prepares an autoload file for you. So if this is your first time using Composer, you'll want to include this at the start of your plugin or theme:

```php
require 'vendor/autoload.php';
```

### As a standalone WordPress plugin

Syllables is able to run like a regular WordPress plugin. Even though it doesn't do anything by itself, it does make its classes and functions available  so you don't have to include it as a dependency in every single one of your plugins or themes.

Clone this repository into your install's _/wp-content/plugins_ directory, then install Syllable's own dependencies by running [Composer](https://getcomposer.org/):

```
$ cd /path/to/wp-content/plugins
$ git clone https://github.com/goblindegook/Syllables.git syllables
$ cd syllables
$ composer install
```

You can now log into the Dashboard, navigate to "Plugins" and activate "Syllables".

### As a must-use WordPress plugin

To prevent the plugin from being disabled and thus breaking your site, you may install it as a MU (must use) plugin. The process is similar to the above, except you clone this repository into the _/wp-content/mu-plugins_ directory.

Because WordPress doesn't look for must-use plugins in subfolders, you will also need to copy the _syllables-mu.php_ file into the parent directory.

```
$ cd /path/to/wp-content/mu-plugins
$ git clone https://github.com/goblindegook/Syllables.git syllables
$ cd syllables
$ composer install
$ cp syllables-mu.php ..
```

## Development builds

Syllables uses Gulp to automate builds through the following tasks:

* `gulp build`: Installs [Composer](https://getcomposer.org) dependencies.
* `gulp test`: Runs automated PHPUnit tests.
* `gulp watch`: Observes source files for changes and runs unit tests automatically.
* `gulp apigen`: Builds documentation using [ApiGen](http://apigen.org).

## Acknowledgements

* `Syllables\Cache\Fragment` is adapted from [Mark Jaquith's fragment caching class](http://markjaquith.wordpress.com/2013/04/26/fragment-caching-in-wordpress/).

## License

Syllables is licensed under the GPL, version 2.0 or any later version. See `LICENSE`.
