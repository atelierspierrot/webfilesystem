<?php

/**
 * Show errors at least initially
 *
 * `E_ALL` => for hard dev
 * `E_ALL & ~E_STRICT` => for hard dev in PHP5.4 avoiding strict warnings
 * `E_ALL & ~E_NOTICE & ~E_STRICT` => classic setting
 */
@ini_set('display_errors', '1'); @error_reporting(E_ALL);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_STRICT);
//@ini_set('display_errors','1'); @error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);

/**
 * Set a default timezone to avoid PHP5 warnings
 */
$dtmz = @date_default_timezone_get();
date_default_timezone_set($dtmz?:'Europe/Paris');

/**
 * For security, transform a realpath as '/[***]/package_root/...'
 *
 * @param string $path
 * @param int $depth_from_root
 *
 * @return string
 */
function _getSecuredRealPath($path, $depth_from_root = 1)
{
    $ds = DIRECTORY_SEPARATOR;
    $parts = explode($ds, realpath('.'));
    for ($i=0; $i<=$depth_from_root; $i++) {
        array_pop($parts);
    }
    return str_replace(join($ds, $parts), $ds.'[***]', $path);
}

/**
 * GET arguments settings
 */
$arg_ln = isset($_GET['ln']) ? $_GET['ln'] : 'en';
$arg_dir = isset($_GET['dir']) ? rtrim($_GET['dir'], '/').'/' : 'parts/';
$img_dir = isset($_GET['img_dir']) ? rtrim($_GET['img_dir'], '/').'/' : 'photos/';
$vidz_dir = isset($_GET['videos_dir']) ? rtrim($_GET['videos_dir'], '/').'/' : 'videos/';
$arg_root = isset($_GET['root']) ? $_GET['root'] : __DIR__;
$arg_i = isset($_GET['i']) ? $_GET['i'] : 0;

require_once '../vendor/autoload.php';

/*
use WebFilesystem\Finder;

$finder = Finder::create()
    ->files()
//    ->dirs()
    ->links()
//    ->dots()
//    ->name('*.html')
//    ->name('*.html?')
//    ->name('*.jpg')
//    ->images()
//    ->videos()
    ->depth('0')
//    ->depth('1')
    ->in(__DIR__.'/test')
//    ->notIn('subfolder_2')
//    ->root(__DIR__.'/../')
    ;


foreach($finder as $key=>$val) {
    $val->setRootDir(__DIR__);
    echo '<br />'.$key.' : '.$val->getFilename();
    if ($finder->isFile()) {
        echo ' | is file';
        if ($finder->isImage()) {
            echo ' | is image file';
        }
        if ($finder->isVideo()) {
            echo ' | is video file';
        }
        if ($finder->is(array('htm','html'))) {
            echo ' | is HTML';
        }
    } elseif ($finder->isDir()) {
        echo ' | is dir';
    }
}

echo '<pre>';
var_export($finder);
echo '</pre>';
exit('yo');
*/

function getPhpClassManualLink($class_name, $ln='en')
{
    return sprintf('http://php.net/manual/%s/class.%s.php', $ln, strtolower($class_name));
}

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Test & documentation of PHP "WebFilesystem" package</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/normalize.css" />
    <link rel="stylesheet" href="assets/html5boilerplate/css/main.css" />
    <script src="assets/html5boilerplate/js/vendor/modernizr-2.6.2.min.js"></script>
	<link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <header id="top" role="banner">
        <hgroup>
            <h1>The PHP "<em>WebFilesystem</em>" package</h1>
            <h2 class="slogan">a collection of classes to manage web files and directories and loop over their contents.</h2>
        </hgroup>
        <div class="hat">
            <p>These pages show and demonstrate the use and functionality of the <a href="https://github.com/atelierspierrot/webfilesystem">atelierspierrot/webfilesystem</a> PHP package you just downloaded.</p>
        </div>
    </header>

	<nav>
		<h2>Map of the package</h2>
        <ul id="navigation_menu" class="menu" role="navigation">
            <li><a href="index.html">Homepage</a>
            <ul>
                <li><a href="#notes">First notes</a></li>
                <li><a href="#links">Links</a></li>
                <li><a href="#request">Interactions with this page</a></li>
            </ul>
            </li>
            <li><a href="#tests">Tests & Doc</a><ul>
                <li><a href="#usage">WebFilesystem</a></li>
                <li><a href="#WebFileInfo">WebFileInfo</a></li>
                <li><a href="#WebFilesystemIterator">WebFilesystemIterator</a></li>
                <li><a href="#WebRecursiveDirectoryIterator">WebRecursiveDirectoryIterator</a></li>
            </ul></li>
            <li><a href="#filetypes">File types</a><ul>
                <li><a href="#WebImage">WebImage</a></li>
                <li><a href="#WebVideo">WebVideo</a></li>
            </ul></li>
            <li><a href="#Finder">Finder</a></li>
            <li><a href="#wip">Work-in-progress</a></li>
            <li><a href="#spl">Internal SPL classes</a></li>
            <li><a href="#symlinks">Working with symbolic links</a></li>
        </ul>

        <div class="info">
            <p><a href="https://github.com/atelierspierrot/webfilesystem">See online on GitHub</a></p>
            <p class="comment">The sources of this plugin are hosted on <a href="http://github.com">GitHub</a>. To follow sources updates, report a bug or read opened bug tickets and any other information, please see the GitHub website above.</p>
        </div>

    	<p class="credits" id="user_agent"></p>
	</nav>

    <div id="content" role="main">

        <article>

    <h1>Tests of PHP <em>WebFilesystem</em> package</h1>

    <h2 id="notes">First notes</h2>
    <p>All these classes works in a PHP version 5.3 minus environment. They are included in the <em>Namespace</em> <strong>WebFilesystem</strong>.</p>
    <p>For clarity, the examples below are NOT written as a working PHP code when it seems not necessary. For example, rather than write <var>echo "my_string";</var> we would write <var>echo my_string</var> or rather than <var>var_export($data);</var> we would write <var>echo $data</var>. The main code for these classes'usage is written strictly.</p>
    <p>As a reminder, and because it's always useful, have a look at the <a href="http://pear.php.net/manual/<?php echo $arg_ln; ?>/standards.php">PHP common coding standards</a>.</p>

    <h2 id="links">Useful links: standards & inspiration</h2>
	<ul>

	<li><strong><abbr title="Standard PHP Library">SPL</abbr> File Handling</strong>:<ul>
	<li>class 
        <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a>
    </li>
	<li>class
        <a href="<?php echo getPhpClassManualLink('SplFileObject', $arg_ln); ?>" title="See on PHP manual">SplFileObject</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a>
        implements 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
    </li>
	<li>class 
        <a href="<?php echo getPhpClassManualLink('SplTempFileObject', $arg_ln); ?>" title="See on PHP manual">SplTempFileObject</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a>
        implements 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
    </li>
	</ul></li>

	<li><strong><abbr title="Standard PHP Library">SPL</abbr> Iterators</strong>:<ul>
	<li>class 
        <a href="<?php echo getPhpClassManualLink('DirectoryIterator', $arg_ln); ?>" title="See on PHP manual">DirectoryIterator</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a>
        implements 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
    </li>
	<li>class 
        <a href="<?php echo getPhpClassManualLink('FilesystemIterator', $arg_ln); ?>" title="See on PHP manual">FilesystemIterator</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('DirectoryIterator', $arg_ln); ?>" title="See on PHP manual">DirectoryIterator</a>
        implements 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
    </li>
	<li>class 
        <a href="<?php echo getPhpClassManualLink('RecursiveDirectoryIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveDirectoryIterator</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('FilesystemIterator', $arg_ln); ?>" title="See on PHP manual">FilesystemIterator</a>
        implements 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
    </li>
	</ul></li>

	<li><strong>PHP internal interfaces</strong>:<ul>
	<li>interface 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
    </li>
	<li>interface 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
    </li>
	<li>interface 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
    </li>
	<li>interface 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
    </li>
	<li>interface 
        <a href="<?php echo getPhpClassManualLink('Countable', $arg_ln); ?>" title="See on PHP manual">Countable</a>
    </li>
	</ul></li>

	<li>from the <strong><a href="http://symfony.com/">Symfony</a> open source framework</strong>:<ul>
	<li>class 
        <a href="http://api.symfony.com/2.1/Symfony/Component/HttpFoundation/File/File.html" title="See on Symfony2 API manual">File</a>
        extends 
        <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a>
    </li>
	</ul></li>

	<li>about the <strong><a href="http://php.net/manual/fr/language.operators.bitwise.php">PHP bitwise operators</a></strong> used in these classes (<em>article on "bitwise operators" : <a href="http://www.phpntips.com/class-flags-with-bitwise-operators-2010-05/">http://www.phpntips.com/class-flags-with-bitwise-operators-2010-05/</a></em>)</li>

	</ul>

	<h2 id="request">Interactions with this page</h2>

    <p>You can set some specific URL <var>GET</var> arguments to customize these demonstrations:</p>

    <pre class="code">
// Use the `dir` argument for default directory tested:
index.php?dir=MY_DIR

// Use the `img_dir` argument for images directory tested:
index.php?img_dir=MY_DIR

// Use the `videos_dir` argument for videos directory tested:
index.php?videos_dir=MY_DIR

// Use the `root` argument for tests root directory (default is `__DIR__`):
index.php?root=MY_DIR
    </pre>

	<h2 id="tests">Tests & documentation</h2>
    
    <h3 id="usage">Including the <em>WebFilesystem</em> package in your work</h3>

    <p>As the package classes names are built following the <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md">PHP Framework Interoperability Group recommandations</a>, we use the <a href="https://gist.github.com/jwage/221634">SplClassLoader</a> to load package classes. The loader is included in the package but you can use your own.</p>

    <pre class="code" data-language="php">
<?php
echo 'require_once "src/SplClassLoader.php";'."\n";
echo '$classLoader = new SplClassLoader("WebFilesystem", "/path/to/package/root/");'."\n";
echo '$classLoader->register();'."\n";
require_once '../src/SplClassLoader.php';
$classLoader = new SplClassLoader('WebFilesystem', __DIR__.'/../src');
$classLoader->register();
?>
    </pre>

    <div class="">
    </div>

    <h3 id="WebFileInfo">Test of class <em>WebFilesystem\WebFileInfo</em>  extending  <a href="<?php echo getPhpClassManualLink('SplFileInfo', $arg_ln); ?>" title="See on PHP manual">SplFileInfo</a></h3>

    <pre class="code" data-language="php">
<?php
echo '// Declaration of the `WebFilesystem\WebFileInfo` class:'."\n";
echo 'use WebFilesystem\WebFileInfo;'."\n";
use WebFilesystem\WebFileInfo;

echo "\n\n";
echo '// Tests of class\'s constants:'."\n";
echo 'echo WebFileInfo::STAT_DATETIME_FIELD; // '.var_export(WebFileInfo::STAT_DATETIME_FIELD, 1)."\n";
echo 'echo WebFileInfo::STAT_SIZE_FIELD; // '.var_export(WebFileInfo::STAT_SIZE_FIELD, 1)."\n";
echo 'echo WebFileInfo::STAT_DATETIME_FIELD | WebFileInfo::STAT_SIZE_FIELD; // '.var_export(WebFileInfo::STAT_DATETIME_FIELD | WebFileInfo::STAT_SIZE_FIELD, 1)."\n";

echo "\n\n";
echo '// Test of `WebFileInfo` class: (in the example, our testing file is "photos/license.txt")'."\n";
echo '$test = new WebFileInfo( "photos/license.txt", __DIR__ );'."\n";
$test = new WebFileInfo("photos/license.txt", __DIR__);

echo "\n\n";
echo '// Test of some properties form the `SplFileInfo` class:'."\n";
echo 'echo $test->getFilename(); // '.var_export(_getSecuredRealPath($test->getFilename()), 1)."\n";
echo 'echo $test->getBasename(); // '.var_export(_getSecuredRealPath($test->getBasename()), 1)."\n";
echo 'echo $test->getPath(); // '.var_export(_getSecuredRealPath($test->getPath()), 1)."\n";
echo 'echo $test->getPathname(); // '.var_export(_getSecuredRealPath($test->getPathname()), 1)."\n";
echo 'echo $test->getRealPath(); // '.var_export(_getSecuredRealPath($test->getRealPath()), 1)."\n";
echo 'echo $test->getExtension(); // '.var_export($test->getExtension(), 1)."\n";

echo "\n\n";
echo '// Test of some properties added by the `WebFileInfo` class:'."\n";
echo 'echo $test->getRootDir(); // '.var_export(_getSecuredRealPath($test->getRootDir()), 1)."\n";
echo 'echo $test->rootDirExists(); // '.var_export($test->rootDirExists(), 1)."\n";
echo 'echo $test->pathExists(); // '.var_export($test->pathExists(), 1)."\n";
echo 'echo $test->getWebPath(); // '.var_export(_getSecuredRealPath($test->getWebPath()), 1)."\n";
echo 'echo $test->getRealWebPath(); // '.var_export(_getSecuredRealPath($test->getRealWebPath()), 1)."\n";
echo 'echo $test->exists(); // '.var_export($test->exists(), 1)."\n";
echo 'echo $test->getHumanReadableFilename(); // '.var_export($test->getHumanReadableFilename(), 1)."\n";
echo 'echo $test->getMime(); // '.var_export($test->getMime(), 1)."\n";
echo 'echo $test->getCharset(); // '.var_export($test->getCharset(), 1)."\n";
echo 'echo $test->getMimeType(); // '.var_export($test->getMimeType(), 1)."\n";

echo "\n\n";
echo '// Test of link to the `RealWebPath` value:'."\n";
echo 'echo &lt;a href="$test->getRealWebPath()"&gt;test link&lt;/a&gt;'."\n";
echo '<a href="'.$test->getRealWebPath().'">test link</a>'."\n";

echo "\n\n";
echo '// Test of classic stat informations retrieving:'."\n";
echo 'echo $test->getStat();'."\n";
echo var_export($test->getStat(), 1)."\n";

echo "\n\n";
echo '// Same stat informations setting flags on `WebFileInfo::STAT_DATETIME_FIELD` (no human readable size field):'."\n";
echo 'echo $test->setFlags(WebFileInfo::STAT_DATETIME_FIELD)->getStat();'."\n";
echo var_export($test->setFlags(WebFileInfo::STAT_DATETIME_FIELD)->getStat(), 1)."\n";

echo "\n\n";
echo '// Same stat informations setting flags on `WebFileInfo::STAT_SIZE_FIELD` (no datetime fields):'."\n";
echo 'echo $test->setFlags(WebFileInfo::STAT_SIZE_FIELD)->getStat();'."\n";
echo var_export($test->setFlags(WebFileInfo::STAT_SIZE_FIELD)->getStat(), 1)."\n";

echo "\n\n";
echo '// Same stat informations setting flags on `null` or `0` or `false` (classic `stat()` fields):'."\n";
echo 'echo $test->setFlags(null)->getStat();'."\n";
echo var_export($test->setFlags(null)->getStat(), 1)."\n";
?>
    </pre>

    <h3 id="WebFilesystemIterator">Test of class <em>WebFilesystem\WebFilesystemIterator</em> extending 
        <a href="<?php echo getPhpClassManualLink('FilesystemIterator', $arg_ln); ?>" title="See on PHP manual">FilesystemIterator</a>
        implementing 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Countable', $arg_ln); ?>" title="See on PHP manual">Countable</a>
    </h3>

    <pre class="code" data-language="php">
<?php
echo '// Declaration of class `WebFilesystem\WebFilesystemIterator` class:'."\n";
echo 'use WebFilesystem\WebFilesystemIterator;'."\n";
use WebFilesystem\WebFilesystemIterator;

echo "\n";
echo '## Test of `WebFilesystemIterator` class on "'.$arg_dir.'":'."\n";
echo '$wfsi_test = new WebFilesystemIterator( "'.$arg_dir.'" );'."\n";
$wfsi_test = new WebFilesystemIterator($arg_dir);
echo 'echo $wfsi_test->getFlags();'."\n";
echo "\t".'=> '.var_export($wfsi_test->getFlags(), 1)."\n";
echo 'echo count($wfsi_test);'."\n";
echo "\t".'=> '.var_export(count($wfsi_test), 1)."\n";

echo "\n";
echo '## Loop on $wfsi_test:'."\n";
echo 'foreach($wfsi_test as $_f)'."\n";
echo '{'."\n";
echo "\t".'echo $wfsi_test->key() => $_f->getFilename() [get_class($wfsi_test->current())] [get_class($_f)];'."\n";
echo '}'."\n";

echo "\n";
echo '## Result of the loop is:'."\n";
foreach ($wfsi_test as $_f) {
    echo "\t".$wfsi_test->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($wfsi_test->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
}

echo "\n";
echo '## Redefinition of default internal `FilesystemIterator` flags on $wfsi_test: WebFilesystemIterator::KEY_AS_PATHNAME | WebFilesystemIterator::CURRENT_AS_FILEINFO | WebFilesystemIterator::SKIP_DOTS'."\n";
echo '$wfsi_test->setFlags(WebFilesystemIterator::KEY_AS_PATHNAME | WebFilesystemIterator::CURRENT_AS_FILEINFO | WebFilesystemIterator::SKIP_DOTS);'."\n";
$wfsi_test->setFlags(WebFilesystemIterator::KEY_AS_PATHNAME | WebFilesystemIterator::CURRENT_AS_FILEINFO | WebFilesystemIterator::SKIP_DOTS);
echo 'echo $wfsi_test->getFlags();'."\n";
echo "\t".'=> '.var_export($wfsi_test->getFlags(), 1)."\n";

echo "\n";
echo '## Result of the loop is now:'."\n";
foreach ($wfsi_test as $_f) {
    echo "\t".$wfsi_test->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($wfsi_test->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
}
?>
    </pre>

    <h3 id="WebRecursiveDirectoryIterator">Test of class <em>WebFilesystem\WebRecursiveDirectoryIterator</em> extending 
        <em>WebFilesystem\WebFilesystemIterator</em>
        implementing 
        <a href="<?php echo getPhpClassManualLink('Traversable', $arg_ln); ?>" title="See on PHP manual">Traversable</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Iterator', $arg_ln); ?>" title="See on PHP manual">Iterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('SeekableIterator', $arg_ln); ?>" title="See on PHP manual">SeekableIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('RecursiveIterator', $arg_ln); ?>" title="See on PHP manual">RecursiveIterator</a>
        , 
        <a href="<?php echo getPhpClassManualLink('Countable', $arg_ln); ?>" title="See on PHP manual">Countable</a>
    </h3>

    <pre class="code" data-language="php">
<?php

echo '// Declaration of class `WebFilesystem\WebRecursiveDirectoryIterator` class:'."\n";
echo 'use WebFilesystem\WebRecursiveDirectoryIterator;'."\n";
use WebFilesystem\WebRecursiveDirectoryIterator;

echo "\n";
echo '## Test of `WebRecursiveDirectoryIterator` class on "'.$img_dir.'/":'."\n";
echo '$wrdi_test = new WebRecursiveDirectoryIterator( "'.$img_dir.'" );'."\n";
$wrdi_test = new WebRecursiveDirectoryIterator($img_dir);
echo 'echo $wrdi_test->getFlags();'."\n";
echo "\t".'=> '.var_export($wrdi_test->getFlags(), 1)."\n";
echo 'echo count($wrdi_test);'."\n";
echo "\t".'=> '.var_export(count($wrdi_test), 1)."\n";

echo "\n";
echo '## Loop on $wrdi_test:'."\n";
echo 'foreach($wrdi_test as $_f)'."\n";
echo '{'."\n";
echo "\t".'echo $wrdi_test->key() => $_f->getFilename() [get_class($wrdi_test->current())] [get_class($_f)];'."\n";
echo "\t".'echo $wrdi_test->hasChildren();'."\n";
echo "\t".'if ($wrdi_test->hasChildren()) echo $wrdi_test->getChildren() [get_class($wrdi_test->getChildren())] [$wrdi_test->getSubPath()] [$wrdi_test->getSubPathName()];'."\n";
echo '}'."\n";

echo "\n";
echo '## Result of the loop is:'."\n";
foreach ($wrdi_test as $_f) {
    echo "\t".$wrdi_test->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($wrdi_test->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
    echo "\t".var_export($wrdi_test->hasChildren(), 1)."\n";
    if ($wrdi_test->hasChildren()) {
        echo "\t".var_export($wrdi_test->getChildren(), 1)
        ."\t".'['.get_class($wrdi_test->getChildren()).']'
        ."\t".'['.var_export($wrdi_test->getSubPath(), 1).']'
        ."\t".'['.var_export($wrdi_test->getSubPathName(), 1).']'
        ."\n";
    }
}

echo "\n\n";
echo '## Test of `WebRecursiveDirectoryIterator` class on photos with callback `WebFilesystem\WebFilesystem::isCommonImage`: (see "photos/")'."\n";
echo '$wrdic_test = new WebRecursiveDirectoryIterator( "photos", 16432, "WebFilesystem\WebFilesystem::isCommonImage" );'."\n";
$wrdic_test = new WebRecursiveDirectoryIterator("photos", 16432, "WebFilesystem\WebFilesystem::isCommonImage");
echo 'echo $wrdic_test->getFlags();'."\n";
echo "\t".'=> '.var_export($wrdic_test->getFlags(), 1)."\n";
echo 'echo count($wrdic_test);'."\n";
echo "\t".'=> '.var_export(count($wrdic_test), 1)."\n";
echo 'echo $wrdic_test->recursiveCount();'."\n";
echo "\t".'=> '.var_export($wrdic_test->recursiveCount(), 1)."\n";
echo 'echo $wrdic_test->getFileValidationCallback();'."\n";
echo "\t".'=> '.var_export($wrdic_test->getFileValidationCallback(), 1)."\n";
echo 'echo $wrdic_test->getDirectoryValidationCallback();'."\n";
echo "\t".'=> '.var_export($wrdic_test->getDirectoryValidationCallback(), 1)."\n";

echo "\n\n";
echo '## Test of looping over directory contents:'."\n";
echo 'foreach($wrdic_test as $i=>$_src)'."\n";
echo '{'."\n";
echo '  // ...'."\n";
echo '}'."\n";

echo "\n\n";
echo '## Restult of the loop is:'."\n";
foreach ($wrdic_test as $i=>$_photo) {
    echo '### For image '.$i.':'."\n";
    echo "\t".'echo $_photo->getHumanReadableFilename();'."\n";
    echo "\t\t".'=> '.var_export($_photo->getHumanReadableFilename(), 1)."\n";
    echo "\t".'echo $_photo->getWebPath();'."\n";
    echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getWebPath()), 1)."\n";
    echo "\t".'echo $_photo->getRealWebPath();'."\n";
    echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getRealWebPath()), 1)."\n";
}

echo "\n\n";
echo '## Setting a custom file class:'."\n";
echo 'use WebFilesystem\FileType\WebImage;'."\n";
echo '$wrdic_test->setFileClass( "WebFilesystem\FileType\WebImage" );'."\n";
use WebFilesystem\FileType\WebImage;

$wrdic_test->setFileClass('WebFilesystem\FileType\WebImage');

echo "\n\n";
echo '## Restult of the loop is now:'."\n";
foreach ($wrdic_test as $i=>$_photo) {
    echo '### For image '.$i.':'."\n";
    echo "\t".'echo $_photo->getHumanReadableFilename();'."\n";
    echo "\t\t".'=> '.var_export($_photo->getHumanReadableFilename(), 1)."\n";
    echo "\t".'echo $_photo->getWebPath();'."\n";
    echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getWebPath()), 1)."\n";
    echo "\t".'echo $_photo->getRealWebPath();'."\n";
    echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getRealWebPath()), 1)."\n";
    echo "\t".'echo if (!$wrdic_test->hasChildren()) $_photo->getThumbWebPath();'."\n";
    if (!$wrdic_test->hasChildren()) {
        echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getThumbWebPath()), 1)."\n";
    }
    echo "\t".'echo if (!$wrdic_test->hasChildren()) $_photo->getThumbRealWebPath();'."\n";
    if (!$wrdic_test->hasChildren()) {
        echo "\t\t".'=> '.var_export(_getSecuredRealPath($_photo->getThumbRealWebPath()), 1)."\n";
    }
    echo "\t".'echo if (!$wrdic_test->hasChildren()) $_photo->thumbExists();'."\n";
    if (!$wrdic_test->hasChildren()) {
        echo "\t\t".'=> '.var_export($_photo->thumbExists(), 1)."\n";
    }
}
?>
    </pre>

    <hr />
    <h2 id="filetypes">File types</h2>

    <h3 id="WebImage">Test of class <em>WebFilesystem\FileType\WebImage</em> extending 
        <em>WebFilesystem\WebFileInfo</em>
    </h3>

    <pre class="code" data-language="php">
<?php
use WebFilesystem\WebFilesystem;

$dir_photos_test = new WebRecursiveDirectoryIterator($img_dir,
    \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_PATHNAME | WebFilesystemIterator::SKIP_DOTTED,
    "WebFilesystem\WebFilesystem::isCommonImage");

echo "\n\n";
echo '## Test of `WebImage` class: (in the example, our testing image is the first in "'.$img_dir.'")'."\n";
echo '$photo = new WebImage( $dir->getPath(), __DIR__, $dir_test->getFilename() );'."\n";
$photo = new WebImage($dir_photos_test->getPath(), $arg_root, $dir_photos_test->getFilename());

echo "\n\n";
echo '## Test of class directory validator:'."\n";
echo 'echo $photo->isImage(); '."\n";
echo "\t".'=> '.var_export($photo->isImage(), 1);

echo "\n\n";
echo '## Test of some class properties (`WebFileInfo` class):'."\n";
echo 'echo $photo->getFilename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getFilename()), 1)."\n";
echo 'echo $photo->getBasename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getBasename()), 1)."\n";
echo 'echo $photo->getPathname(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getPathname()), 1)."\n";
echo 'echo $photo->getPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getPath()), 1)."\n";
echo 'echo $photo->getRealPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getRealPath()), 1)."\n";
echo 'echo $photo->getExtension(); '."\n";
echo "\t".'=> '.var_export($photo->getExtension(), 1)."\n";

echo "\n\n";
echo '## Test of some class properties (`WebImage` class):'."\n";
echo 'echo $photo->getWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getWebPath()), 1)."\n";
echo 'echo $photo->getRealWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getRealWebPath()), 1)."\n";
echo 'echo $photo->getThumbBasename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getThumbBasename()), 1)."\n";
echo 'echo $photo->getThumbWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getThumbWebPath()), 1)."\n";
echo 'echo $photo->getThumbRealWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getThumbRealWebPath()), 1)."\n";
echo 'echo $photo->getThumbPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getThumbPath()), 1)."\n";
echo 'echo $photo->getThumbRealPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($photo->getThumbRealPath()), 1)."\n";
echo 'echo $photo->getHumanReadableFilename(); '."\n";
echo "\t".'=> '.var_export($photo->getHumanReadableFilename(), 1)."\n";

echo "\n\n";
echo '## Test of classic stat informations retrieving:'."\n";
echo 'echo $photo->getStat();'."\n";
echo "\t".'=> '.var_export($photo->getStat(), 1)."\n";

echo "\n\n";
echo '## Test of image internal informations retrieving:'."\n";
echo 'echo $photo->getInfos();'."\n";
echo "\t".'=> '.var_export($photo->getInfos(), 1)."\n";
?>
    </pre>

    <h3 id="WebVideo">Test of class <em>WebFilesystem\FileType\WebVideo</em> extending 
        <em>WebFilesystem\WebFileInfo</em>
    </h3>

    <pre class="code" data-language="php">
<?php
use WebFilesystem\FileType\WebVideo;

$dir_photos_test = new WebRecursiveDirectoryIterator($vidz_dir,
    \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_PATHNAME | WebFilesystemIterator::SKIP_DOTTED,
    "WebFilesystem\WebFilesystem::isCommonVideo");


echo "\n\n";
echo '## Test of `WebVideo` class: (in the example, our testing image is the first in "'.$img_dir.'")'."\n";
echo '$video = new WebVideo( $dir->getPath(), __DIR__, $dir_test->getFilename() );'."\n";
$video = new WebVideo($dir_photos_test->getPath(), $arg_root, $dir_photos_test->getFilename());

echo "\n\n";
echo '## Test of class directory validator:'."\n";
echo 'echo $video->isVideo(); '."\n";
echo "\t".'=> '.var_export($video->isVideo(), 1);

echo "\n\n";
echo '## Test of some class properties (`WebFileInfo` class):'."\n";
echo 'echo $video->getFilename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getFilename()), 1)."\n";
echo 'echo $video->getBasename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getBasename()), 1)."\n";
echo 'echo $video->getPathname(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getPathname()), 1)."\n";
echo 'echo $video->getPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getPath()), 1)."\n";
echo 'echo $video->getRealPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getRealPath()), 1)."\n";
echo 'echo $video->getExtension(); '."\n";
echo "\t".'=> '.var_export($video->getExtension(), 1)."\n";

echo "\n\n";
echo '## Test of some class properties (`WebImage` class):'."\n";
echo 'echo $video->getWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getWebPath()), 1)."\n";
echo 'echo $video->getRealWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getRealWebPath()), 1)."\n";
echo 'echo $video->getThumbBasename(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getThumbBasename()), 1)."\n";
echo 'echo $video->getThumbWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getThumbWebPath()), 1)."\n";
echo 'echo $video->getThumbRealWebPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getThumbRealWebPath()), 1)."\n";
echo 'echo $video->getThumbPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getThumbPath()), 1)."\n";
echo 'echo $video->getThumbRealPath(); '."\n";
echo "\t".'=> '.var_export(_getSecuredRealPath($video->getThumbRealPath()), 1)."\n";
echo 'echo $video->getHumanReadableFilename(); '."\n";
echo "\t".'=> '.var_export($video->getHumanReadableFilename(), 1)."\n";

echo "\n\n";
echo '## Test of classic stat informations retrieving:'."\n";
echo 'echo $video->getStat();'."\n";
echo "\t".'=> '.var_export($video->getStat(), 1)."\n";

echo "\n\n";
echo '## Test of image internal informations retrieving:'."\n";
echo 'echo $video->getInfos();'."\n";
echo "\t".'=> '.var_export($video->getInfos(), 1)."\n";
?>
    </pre>

    <h2 id="Finder">Test of class <em>WebFilesystem\Finder</em></h2>

    <p>The <var>WebFilesystem\Finder</var> class is a helper to iterate over a directory content, recursively, setting up a set of conditions.</p>

    <pre class="code" data-language="php">
<?php
use WebFilesystem\Finder;

echo 'use WebFilesystem\Finder;'."\n";
echo "\n";

echo '// For each of the examples below, rendering is:'."\n";
echo 'foreach($finder as $key=>$val) {'."\n"
    ."\t".'$val->setRootDir(__DIR__);'."\n"
    ."\t".'echo $key." : ".$val->getFilename();'."\n"
    ."\t".'if ($finder->isFile()) {'."\n"
    ."\t\t".'echo " | is file";'."\n"
    ."\t\t".'if ($finder->isDotFile()) echo " | is dot file";'."\n"
    ."\t\t".'if ($finder->isImage()) echo " | is image file";'."\n"
    ."\t\t".'if ($finder->isVideo()) echo " | is video file";'."\n"
    ."\t\t".'if ($finder->is(array("htm","html"))) echo " | is HTML";'."\n"
    ."\t".'}'."\n"
    ."\t".'elseif ($finder->isDir()) echo " | is dir";'."\n"
    .'}'."\n";

echo "\n";
echo '// test one: loop over everything, recursively, except dot files (by default)'."\n";
echo '$finder = Finder::create()'."\n"
    ."\t".'->files()'."\n"
    ."\t".'->dirs()'."\n"
    ."\t".'->links()'."\n"
    ."\t".'->in(__DIR__."/test");'."\n";
$finder = Finder::create()
    ->files()
    ->dirs()
    ->links()
    ->in(__DIR__.'/test')
    ;
foreach ($finder as $key=>$val) {
    $val->setRootDir(__DIR__);
    echo $key.' : '.$val->getFilename();
    if ($finder->isFile()) {
        echo ' | is file';
        if ($finder->isDotFile()) {
            echo ' | is dot file';
        }
        if ($finder->isImage()) {
            echo ' | is image file';
        }
        if ($finder->isVideo()) {
            echo ' | is video file';
        }
        if ($finder->is(array('htm', 'html'))) {
            echo ' | is HTML';
        }
    } elseif ($finder->isDir()) {
        echo ' | is dir';
    }
    echo "\n";
}

echo "\n";
echo '// test two: same loop with dot files excluding "subfolder_2/"'."\n";
echo '$finder = Finder::create()'."\n"
    ."\t".'->files()'."\n"
    ."\t".'->dirs()'."\n"
    ."\t".'->links()'."\n"
    ."\t".'->dots()'."\n"
    ."\t".'->in(__DIR__."/test")'."\n"
    ."\t".'->notIn("subfolder_2");'."\n";
$finder = Finder::create()
    ->files()
    ->dirs()
    ->links()
    ->dots()
    ->in(__DIR__.'/test')
    ->notIn('subfolder_2')
    ;
foreach ($finder as $key=>$val) {
    $val->setRootDir(__DIR__);
    echo $key.' : '.$val->getFilename();
    if ($finder->isFile()) {
        echo ' | is file';
        if ($finder->isDotFile()) {
            echo ' | is dot file';
        }
        if ($finder->isImage()) {
            echo ' | is image file';
        }
        if ($finder->isVideo()) {
            echo ' | is video file';
        }
        if ($finder->is(array('htm', 'html'))) {
            echo ' | is HTML';
        }
    } elseif ($finder->isDir()) {
        echo ' | is dir';
    }
    echo "\n";
}

echo "\n";
echo '// test three: same loop getting only images and videos with a recursion depth of 1'."\n";
echo '$finder = Finder::create()'."\n"
    ."\t".'->files()'."\n"
    ."\t".'->links()'."\n"
    ."\t".'->images()'."\n"
    ."\t".'->videos()'."\n"
    ."\t".'->depth("1")'."\n"
    ."\t".'->in(__DIR__."/test");'."\n";
$finder = Finder::create()
    ->files()
    ->links()
    ->images()
    ->videos()
    ->depth('1')
    ->in(__DIR__.'/test')
    ;
foreach ($finder as $key=>$val) {
    $val->setRootDir(__DIR__);
    echo $key.' : '.$val->getFilename();
    if ($finder->isFile()) {
        echo ' | is file';
        if ($finder->isDotFile()) {
            echo ' | is dot file';
        }
        if ($finder->isImage()) {
            echo ' | is image file';
        }
        if ($finder->isVideo()) {
            echo ' | is video file';
        }
        if ($finder->is(array('htm', 'html'))) {
            echo ' | is HTML';
        }
    } elseif ($finder->isDir()) {
        echo ' | is dir';
    }
    echo "\n";
}

echo "\n";
echo '// test four: same loop matching only "jpg" and "htm(l)" files'."\n";
echo '$finder = Finder::create()'."\n"
    ."\t".'->files()'."\n"
    ."\t".'->name("*.html?")'."\n"
    ."\t".'->name("*.jpg")'."\n"
    ."\t".'->in(__DIR__."/test");'."\n";
$finder = Finder::create()
    ->files()
    ->name('*.html?')
    ->name('*.jpg')
    ->in(__DIR__.'/test')
    ;
foreach ($finder as $key=>$val) {
    $val->setRootDir(__DIR__);
    echo $key.' : '.$val->getFilename();
    if ($finder->isFile()) {
        echo ' | is file';
        if ($finder->isDotFile()) {
            echo ' | is dot file';
        }
        if ($finder->isImage()) {
            echo ' | is image file';
        }
        if ($finder->isVideo()) {
            echo ' | is video file';
        }
        if ($finder->is(array('htm', 'html'))) {
            echo ' | is HTML';
        }
    } elseif ($finder->isDir()) {
        echo ' | is dir';
    }
    echo "\n";
}
?>
    </pre>

    <hr />
    <h2 id="wip">Test of w-i-p PHP</h2>

<?php
echo '<p><strong>Bits:</strong></p><ul>';
echo '<li>empty:<ul>';
echo '<li>0x000000: '.var_export(0x000000, 1).'</li>';
echo '</ul></li>';
echo '<li>1x1:<ul>';
echo '<li>0x000001: '.var_export(0x000001, 1).'</li>';
echo '<li>0x000010: '.var_export(0x000010, 1).'</li>';
echo '<li>0x000100: '.var_export(0x000100, 1).'</li>';
echo '<li>0x001000: '.var_export(0x001000, 1).'</li>';
echo '<li>0x010000: '.var_export(0x010000, 1).'</li>';
echo '<li>0x100000: '.var_export(0x100000, 1).'</li>';
echo '</ul></li>';
echo '<li>2x1:<ul>';
echo '<li>0x000011: '.var_export(0x000011, 1).'</li>';
echo '<li>0x000110: '.var_export(0x000110, 1).'</li>';
echo '<li>0x001100: '.var_export(0x001100, 1).'</li>';
echo '<li>0x011000: '.var_export(0x011000, 1).'</li>';
echo '<li>0x110000: '.var_export(0x110000, 1).'</li>';
echo '</ul></li>';
echo '<li>1x1 + last 1:<ul>';
echo '<li>0x000101: '.var_export(0x000101, 1).'</li>';
echo '<li>0x001001: '.var_export(0x001001, 1).'</li>';
echo '<li>0x010001: '.var_export(0x010001, 1).'</li>';
echo '<li>0x100001: '.var_export(0x100001, 1).'</li>';
echo '</ul></li>';
echo '</ul>';

echo '<br /><br /><strong>About current() return:</strong>';
echo '<br />FilesystemIterator::CURRENT_AS_FILEINFO: ';
var_export(\FilesystemIterator::CURRENT_AS_FILEINFO);
echo '<br />FilesystemIterator::CURRENT_AS_SELF: ';
var_export(\FilesystemIterator::CURRENT_AS_SELF);
echo '<br />FilesystemIterator::CURRENT_AS_PATHNAME: ';
var_export(\FilesystemIterator::CURRENT_AS_PATHNAME);
echo '<br />WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO: ';
var_export(\WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO);

echo '<br /><br /><strong>About skip constants:</strong>';
echo '<br />FilesystemIterator::SKIP_DOTS: ';
var_export(\FilesystemIterator::SKIP_DOTS);
echo '<br />WebFilesystem\WebFilesystemIterator::SKIP_DOTTED: ';
var_export(\WebFilesystem\WebFilesystemIterator::SKIP_DOTTED);

echo '<br /><br /><strong>Default flags:</strong>';
echo '<br />FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS: ';
var_export(\FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);
echo '<br />FilesystemIterator::KEY_AS_PATHNAME | WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO | WebFilesystem\WebFilesystemIterator::SKIP_DOTTED: ';
var_export(\FilesystemIterator::KEY_AS_PATHNAME | \WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO | \WebFilesystem\WebFilesystemIterator::SKIP_DOTTED);

echo '<br /><br /><strong>Tests:</strong>';
$a = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS;
$b = \FilesystemIterator::KEY_AS_PATHNAME | \WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO | \WebFilesystem\WebFilesystemIterator::SKIP_DOTTED;
echo '<br />$a = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS';
echo '<br />$b = FilesystemIterator::KEY_AS_PATHNAME | WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO | WebFilesystem\WebFilesystemIterator::SKIP_DOTTED';

$flags = array(
    'FilesystemIterator::CURRENT_AS_FILEINFO',
    'FilesystemIterator::CURRENT_AS_SELF',
    'FilesystemIterator::CURRENT_AS_PATHNAME',
    'WebFilesystem\WebFilesystemIterator::CURRENT_AS_WEBFILEINFO',
    'FilesystemIterator::SKIP_DOTS',
    'WebFilesystem\WebFilesystemIterator::SKIP_DOTTED'
);

foreach ($flags as $flag) {
    echo "<br />Test on flag ".$flag." :";
    eval("\$testa = (\$a & $flag);");
    eval("\$testb = (\$b & $flag);");
    echo "<br />&nbsp;=> on a : ".var_export($testa, 1).' with `if...`: ';
    if ($testa) {
        echo 'ON';
    } else {
        echo 'OFF';
    }
    echo "<br />&nbsp;=> on b : ".var_export($testb, 1).' with `if...`: ';
    if ($testb) {
        echo 'ON';
    } else {
        echo 'OFF';
    }
}

?>

    <pre class="code" data-language="php">
<?php
echo '## Inclusion of web\'s commons `WebFilesystem\WebFilesystem`:'."\n";
echo 'use WebFilesystem\WebFilesystem;'."\n";

echo "\n\n";
echo '## Test of `WebFilesystem::isCommonFile()` method:'."\n";
echo 'echo WebFilesystem::isCommonFile( "my_file.txt" ); // must be true:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonFile("my_file.txt"), 1)."\n";
echo 'echo WebFilesystem::isCommonFile( "._my_file.txt" ); // must be false:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonFile("._my_file.txt"), 1)."\n";
echo 'echo WebFilesystem::isCommonFile( "my_file.txt~" ); // must be false:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonFile("my_file.txt~"), 1)."\n";
echo 'echo WebFilesystem::isCommonFile( "my~file._backup.txt" ); // must be true:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonFile("my~file._backup.txt"), 1)."\n";

echo "\n\n";
echo '## Test of `WebFilesystem::isCommonImage()` method:'."\n";
echo 'echo WebFilesystem::isCommonImage( "my_file.jpg" ); // must be true:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonImage("my_file.jpg"), 1)."\n";
echo 'echo WebFilesystem::isCommonImage( "my_file.txt" ); // must be false:'."\n";
echo "\t".'=> '.var_export(WebFilesystem::isCommonImage("my_file.txt"), 1)."\n";

echo "\n\n";
echo '## Test of `WebFilesystem::getHumanReadableName()` method:'."\n";
echo 'echo WebFilesystem::getHumanReadableName( "my_bizarre.file-name.jpg" ); '."\n";
echo "\t".'=> '.var_export(WebFilesystem::getHumanReadableName("my_bizarre.file-name.jpg"), 1)."\n";

echo "\n\n";
echo '## Creation of a new `WebRecursiveDirectoryIterator` with flags `FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTTED` callback `WebFilesystem\WebFilesystem::isCommonImage`: (dir= "'.$arg_dir.'")'."\n";
echo '$dir_test = new WebRecursiveDirectoryIterator( "'.$arg_dir.'", 16432, "WebFilesystem\WebFilesystem::isCommonImage" );'."\n";
$dir_test = new WebRecursiveDirectoryIterator($arg_dir, FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_PATHNAME | WebFilesystemIterator::SKIP_DOTTED, "WebFilesystem\WebFilesystem::isCommonImage");
echo '## Seeking to item '.$arg_i.':'."\n";
echo '$dir_test->seek( (int) "'.$arg_i.'" );'."\n";
$dir_test->seek(intVal('.$arg_i.'));
echo '$dir_test->getPath();'."\n";
echo "\t".'=> '.$dir_test->getPath()."\n";
echo '$dir_test->getFilename();'."\n";
echo "\t".'=> '.$dir_test->getFilename()."\n";
echo '$dir_test->current();'."\n";
echo "\t".'=> '.$dir_test->current()."\n";
?>
    </pre>

    <hr />
    <h2 id="spl">Tests of internal <em>SPL</em> classes</h2>

    <pre class="code" data-language="php">
<?php

echo "\n";
echo '## Test of `DirectoryIterator` class on "parts/":'."\n";
echo '$dir_obj = new DirectoryIterator( "parts" );'."\n";
$dir_obj = new DirectoryIterator('parts');
echo "\t".'=> '.var_export($dir_obj, 1)."\n";

echo "\n";
echo '## Loop on $dir_obj:'."\n";
echo 'foreach($dir_obj as $_f)'."\n";
echo '{'."\n";
echo "\t".'echo $dir_obj->key() => $_f->getFilename() [get_class($dir_obj->current())] [get_class($_f)];'."\n";
echo '}'."\n";

echo "\n";
echo '## Result of the loop is:'."\n";
foreach ($dir_obj as $_f) {
    echo "\t".$dir_obj->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($dir_obj->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
}

echo "\n";
echo '## Test of `FilesystemIterator` class on "parts/":'."\n";
echo '$dir_obj2 = new FilesystemIterator( "parts" );'."\n";
$dir_obj2 = new FilesystemIterator('parts');
echo 'echo $dir_obj2->getFlags();'."\n";
echo "\t".'=> '.var_export($dir_obj2->getFlags(), 1)."\n";

echo "\n";
echo '## Loop on $dir_obj2:'."\n";
echo 'foreach($dir_obj2 as $_f)'."\n";
echo '{'."\n";
echo "\t".'echo $dir_obj2->key() => $_f->getFilename() [get_class($dir_obj2->current())] [get_class($_f)];'."\n";
echo '}'."\n";

echo "\n";
echo '## Result of the loop is:'."\n";
foreach ($dir_obj2 as $_f) {
    echo "\t".$dir_obj2->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($dir_obj2->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
}

echo "\n";
echo '## Redefinition of flags on $dir_obj2: FilesystemIterator::KEY_AS_FILENAME and FilesystemIterator::CURRENT_AS_SELF'."\n";
echo '$dir_obj2->setFlags(FilesystemIterator::CURRENT_AS_SELF | FilesystemIterator::KEY_AS_FILENAME);'."\n";
$dir_obj2->setFlags(FilesystemIterator::CURRENT_AS_SELF | FilesystemIterator::KEY_AS_FILENAME);
echo 'echo $dir_obj2->getFlags();'."\n";
echo "\t".'=> '.var_export($dir_obj2->getFlags(), 1)."\n";

echo "\n";
echo '## Result of the loop is now:'."\n";
foreach ($dir_obj2 as $_f) {
    echo "\t".$dir_obj2->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($dir_obj2->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
}

echo "\n";
echo '## Test of `RecursiveDirectoryIterator` class on "photos/":'."\n";
echo '$dir_obj3 = new RecursiveDirectoryIterator( "photos" );'."\n";
$dir_obj3 = new RecursiveDirectoryIterator('photos');
echo 'echo $dir_obj3->getFlags();'."\n";
echo "\t".'=> '.var_export($dir_obj3->getFlags(), 1)."\n";

echo "\n";
echo '## Loop on $dir_obj3:'."\n";
echo 'foreach($dir_obj3 as $_f)'."\n";
echo '{'."\n";
echo "\t".'echo $dir_obj3->key() => $_f->getFilename() [get_class($dir_obj3->current())] [get_class($_f)];'."\n";
echo "\t".'echo $dir_obj3->hasChildren();'."\n";
echo "\t".'if ($dir_obj3->hasChildren()) echo $dir_obj3->getChildren() [get_class($dir_obj3->getChildren())] [$dir_obj3->getSubPath()] [$dir_obj3->getSubPathName()];'."\n";
echo '}'."\n";

echo "\n";
echo '## Result of the loop is:'."\n";
foreach ($dir_obj3 as $_f) {
    echo "\t".$dir_obj3->key().' => '.$_f->getFilename()
        ."\t".'['.var_export(get_class($dir_obj3->current()), 1).']'
        ."\t".'['.var_export(get_class($_f), 1).']'
        ."\n";
    echo "\t".var_export($dir_obj3->hasChildren(), 1)."\n";
    if ($dir_obj3->hasChildren()) {
        echo "\t".var_export($dir_obj3->getChildren(), 1)
        ."\t".'['.get_class($dir_obj3->getChildren()).']'
        ."\t".'['.var_export($dir_obj3->getSubPath(), 1).']'
        ."\t".'['.var_export($dir_obj3->getSubPathName(), 1).']'
        ."\n";
    }
}

?>
    </pre>

    <h2 id="symlinks">Working with symbolic links</h2>

    <p>You can make a full test defining a realpath symbolic link in the <var>demo/test/</var> directory.</p>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo '## Test of `WebFilesystemIterator` class on "test/":'."\n";
echo '$wfsi_test = new WebFilesystemIterator( "test" );'."\n";
$wfsi_test = new WebFilesystemIterator('test');

echo "\n";
foreach ($wfsi_test as $_f) {
    echo $wfsi_test->key().' [class '.get_class($_f).']'
        ."\n\t".'pathname is => '.$_f->getPathname()
        ."\n\t".'realpath is => '.$_f->getRealPath()
        ."\n\t".'is link? :: '.var_export($_f->isLink(), 1)
//        .($_f->isLink() ? "\n\t".'linkpath is => '.$_f->getLinkTarget() : '')
        ."\n\n";
}
?>
    </pre>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo '## Test of `WebFilesystemIterator` class on "test/" with the flag "FilesystemIterator::CURRENT_AS_FILEINFO":'."\n";
echo '$wfsi_test = new WebFilesystemIterator( "test", FilesystemIterator::CURRENT_AS_FILEINFO );'."\n";
$wfsi_test_spl = new WebFilesystemIterator('test', FilesystemIterator::CURRENT_AS_FILEINFO);
echo "\n";
foreach ($wfsi_test_spl as $_f) {
    echo $wfsi_test_spl->key().' [class '.get_class($_f).']'
        ."\n\t".'pathname is => '.$_f->getPathname()
        ."\n\t".'realpath is => '.$_f->getRealPath()
        ."\n\t".'is link? :: '.var_export($_f->isLink(), 1)
//        .($_f->isLink() ? "\n\t".'linkpath is => '.$_f->getLinkTarget() : '')
        ."\n\n";
}
?>
    </pre>

    <pre class="code" data-language="php">
<?php
echo "\n";
echo '## Test of `FilesystemIterator` class on "test/":'."\n";
echo '$wfsi_test = new FilesystemIterator( "test" );'."\n";
$wfsi_test = new FilesystemIterator('test');

echo "\n";
foreach ($wfsi_test as $_f) {
    echo $wfsi_test->key().' [class '.get_class($_f).']'
        ."\n\t".'pathname is => '.$_f->getPathname()
        ."\n\t".'realpath is => '.$_f->getRealPath()
        ."\n\t".'is link? :: '.var_export($_f->isLink(), 1)
//        .($_f->isLink() ? "\n\t".'linkpath is => '.$_f->getLinkTarget() : '')
        ."\n\n";
}
?>
    </pre>

        </article>
    </div>

    <footer id="footer">
		<div class="credits float-left">
		    This page is <a href="" title="Check now online" id="html_validation">HTML5</a> & <a href="" title="Check now online" id="css_validation">CSS3</a> valid.
		</div>
		<div class="credits float-right">
		    <a href="https://github.com/atelierspierrot/webfilesystem">atelierspierrot/webfilesystem</a> package by <a href="https://github.com/pierowbmstr">Piero Wbmstr</a> under <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache 2.0</a> license.
		</div>
    </footer>

    <div class="back_menu" id="short_navigation">
        <a href="#" title="See navigation menu" id="short_menu_handler"><span class="text">Navigation Menu</span></a>
        &nbsp;|&nbsp;
        <a href="#top" title="Back to the top of the page"><span class="text">Back to top&nbsp;</span>&uarr;</a>
        <ul id="short_menu" class="menu" role="navigation"></ul>
    </div>

    <div id="message_box" class="msg_box"></div>

<!-- jQuery lib -->
<script src="assets/js/jquery-1.9.1.min.js"></script>

<!-- HTML5 boilerplate -->
<script src="assets/html5boilerplate/js/plugins.js"></script>

<!-- jQuery.tablesorter plugin -->
<script src="assets/js/jquery.tablesorter.min.js"></script>

<!-- jQuery.highlight plugin -->
<script src="assets/js/highlight.js"></script>

<!-- scripts for demo -->
<script src="assets/scripts.js"></script>

<script>
$(function() {
    initBacklinks();
    activateMenuItem();
    getToHash();
    buildFootNotes();
    addCSSValidatorLink('assets/styles.css');
    addHTMLValidatorLink();
    $("#user_agent").html( navigator.userAgent );
    $('pre.code').highlight({source:0, indent:'tabs', code_lang: 'data-language'});
});
</script>
</body>
</html>
