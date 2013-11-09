<?php
/**
 * See http://github.com/fabpot/Sami
 *
 * To build doc, run:
 *     $ php sami.php render path/to/this/file.php
 *
 * To update it, run:
 *     $ php sami.php update path/to/this/file.php
 *
 */

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->notName('SplClassLoader.php')
    ->in(__DIR__.'/src')
;

$options = array(
    'title'                => 'WebFilesystem',
    'build_dir'            => __DIR__.'/phpdoc',
    'cache_dir'            => __DIR__.'/../tmp/cache/webfilesystem',
    'default_opened_level' => 2,
);

return new Sami($iterator, $options);

// Endfile