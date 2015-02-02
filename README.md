# Syllables

Syllables are helper classes and functions for WordPress development.

[![Latest Stable Version](https://poser.pugx.org/goblindegook/syllables/v/stable.svg)](https://packagist.org/packages/goblindegook/syllables) [![Latest Unstable Version](https://poser.pugx.org/goblindegook/syllables/v/unstable.svg)](https://packagist.org/packages/goblindegook/syllables) [![Build Status](https://travis-ci.org/goblindegook/Syllables.svg?branch=master)](https://travis-ci.org/goblindegook/Syllables) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/goblindegook/Syllables/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/goblindegook/Syllables/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/goblindegook/Syllables/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/goblindegook/Syllables/?branch=master)

## Installation

To install this library as a dependency in your WordPress project using [Composer](https://getcomposer.org/), run the following command to get the latest version:

```
$ composer require goblindegook/syllables
```

By default, Composer will install Syllables as a plugin in the _wp-content/plugins/syllables_ directory. You may then sign into the Dashboard, navigate to "Plugins" and activate "Syllables".

Even though Syllables exists as a plugin, it doesn't do anything by itself, but it does make its classes and functions available so you don't have to include it as a dependency in every single one of your plugins or themes.

### Install as a must-use WordPress plugin

To install Syllables as a must-use plugin (which cannot be turned off by users), make sure your site's _composer.json_ file contains an `extra.installer-paths` section and that `goblindegook/syllables` is set to install in the correct directory:

```
"extra": {
    "installer-paths": {
        "wp-content/mu-plugins/syllables/": ["goblindegook/syllables"]
    }
}
```

Running Composer to install your dependencies will place Syllables into the _wp-content/mu-plugins/syllables_ folder instead.

Now, because WordPress doesn't look for must-use plugins in subfolders, you will also need to copy the _syllables-mu.php_ file provided into the parent directory.

```
$ cd /path/to/wp-content/mu-plugins/syllables
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
