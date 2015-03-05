PHP Web Filesystem package
===========================

[![documentation](http://img.ateliers-pierrot-static.fr/readthe-doc.png)](http://docs.ateliers-pierrot.fr/webfilesystem/)
Extending the SPL file system to manage webserver based file system (such as assets).

## Inclusion & Usage

First, you can clone the [GitHub](https://github.com/atelierspierrot/webfilesystem) repository
and include it "as is" in your poject:

    https://github.com/atelierspierrot/webfilesystem

You can also download an [archive](https://github.com/atelierspierrot/webfilesystem/downloads)
from Github.

Then, to use the package classes, you just need to register the `WebFilesystem` namespace directory
using the [SplClassLoader](https://gist.github.com/jwage/221634) or any other custom autoloader:

```php
require_once '../src/SplClassLoader.php'; // if required, a copy is proposed in the package
$classLoader = new SplClassLoader('WebFilesystem', '/path/to/package/src');
$classLoader->register();
```

If you use [Composer](http://getcomposer.org/) to manage your project's dependencies, including it
is as easy as adding to your `composer.json` file:

```json
"require": {
    "your/deps": "*",
    "atelierspierrot/webfilesystem": "dev-master"
},
```

## Documentation

A configuration file for [Sami](https://github.com/fabpot/Sami) is proposed in the package to
build a documentation of the code.

To generate or update it, run:

    $ php sami.php render/update /path/to/package/sami.config.php

Documentation is rendered in `phpdoc/` directory (*a `/../tmp/` directory will be generated for
sami's cache ; you can delete it after rendering*).

An online version of the generated documentation for the last stable package is available
at <http://docs.ateliers-pierrot.fr/webfilesystem/>.


## Author & License

>    Web Filesystem

>    http://github.com/atelierspierrot/webfilesystem

>    Copyright (c) 2013-2015 Pierre Cassat and contributors

>    Licensed under the Apache 2.0 license.

>    http://www.apache.org/licenses/LICENSE-2.0

>    ----

>    Les Ateliers Pierrot - Paris, France

>    <http://www.ateliers-pierrot.fr/> - <contact@ateliers-pierrot.fr>
