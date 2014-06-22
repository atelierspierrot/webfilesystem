<?php
/**
 * PHP WebFilesystem package of Les Ateliers Pierrot
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webfilesystem>
 */

namespace WebFilesystem;

use \WebFilesystem\WebFilesystem;

use \Library\Helper\Directory as DirectoryHelper;

/**
 * Special web's version of the PHP >=5.1.2 standard class `SplFileInfo` <http://www.php.net/manual/en/class.splfileinfo.php>
 */
class WebFileInfo extends \SplFileInfo
{

    /**
     * Flag to complete the `stat` result with a `DateTime` object for each timestamps
     */
    const STAT_DATETIME_FIELD   = 16;

    /**
     * Flag to complete the `stat` result with a human readable value of the object size
     */
    const STAT_SIZE_FIELD       = 256;

    /**
     * The object flags, by default `STAT_DATETIME_FIELD | STAT_SIZE_FIELD`
     */
    protected $flags;

    /**
     * The absolute path of the root directory
     */
    protected $root_dir         = '';

    /**
     * The file relative path to write as HTTP accessible path
     *
     * This property will be used as `$my_url = $obj->getWebPath() . $obj->getBasename()`
     */
    protected $web_path         = '';

    /**
     * Construct a new WebFileInfo object
     *
     * To be valid for reading, the file `$root_dir / $file_name` must exist.
     *
     * @param string $file_name The path of the file
     * @param string $root_dir The absolute path of the root directory
     * @param int $flags The flags (object's constants) to set for the instance, default is `STAT_DATETIME_FIELD | STAT_SIZE_FIELD`
     */
    public function __construct($file_name, $root_dir = null, $flags = 272)
    {
        $this->setFlags( $flags );
        $this->setWebPath( dirname($file_name) );
        if (!is_null($root_dir)) {
            $this->setRootDir( $root_dir );
        }
        parent::__construct( DirectoryHelper::slashDirname($this->getRootDir()).$file_name );
    }

    /**
     * Set the object's flags
     *
     * @param int $flags The flags value to set (use the class's constants)
     * @return self The object itself is returned for method chaining
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * Gets the object's flags value
     *
     * @return int The object's root directory
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Gets the object extension (not defined before PHP 5.3.6)
     *
     * @return string The extension string of the object if so
     */
    public function getExtension()
    {
        return pathinfo($this->getBasename(), PATHINFO_EXTENSION);
    }

    /**
     * Gets the object realpath if found
     *
     * @return string The absolute canonical path of the file in the server filesystem
     */
    public function getRealPath()
    {
        $path = parent::getRealPath();
        if (empty($path)) {
            $path = $this->getRootDir().$this->getFilename();
        }
        return $path;
    }

    /**
     * Gets the object file name as it was passed to the constructor (relative to `$root_dir`)
     *
     * @return string The relative file path as it was passed to the constructor
     */
    public function getFilename()
    {
        return str_replace($this->getRootDir(), '', $this->getPathname());
    }

    /**
     * Sets the object's root directory
     *
     * @param string $dir_name The absolute path of the root directory
     * @return self The object itself is returned for method chaining
     */
    public function setRootDir($dir_name)
    {
        $this->root_dir = $dir_name;
        $this->setWebPath($this->getWebPath());
        return $this;
    }

    /**
     * Gets the object's root directory
     *
     * @return string The object's root directory
     */
    public function getRootDir()
    {
        return (!empty($this->root_dir) ? DirectoryHelper::slashDirname($this->root_dir) : '');
    }

    /**
     * Sets the object web path (relative to `$root_dir`)
     *
     * @param string $path The path to set, without the file name
     * @return self The object itself is returned for method chaining
     */
    public function setWebPath($path)
    {
        $this->web_path = $path;
        return $this;
    }

    /**
     * Gets the object's web path
     *
     * @return string The object's web path, without the file name
     */
    public function getWebPath()
    {
        return (!empty($this->web_path) ? str_replace($this->getRootDir(), '', DirectoryHelper::slashDirname($this->web_path)) : '');
    }

    /**
     * Gets the object's web real path (with the file name)
     *
     * This must returns a directly HTML writable directory or file path.
     *
     * @return string The object's full file web path
     */
    public function getRealWebPath()
    {
        return $this->getWebPath().$this->getBasename();
    }

    /**
     * Check if the object exists in the server filesystem
     *
     * @return bool `true` if it exists, `false` otherwise
     */
    public function exists()
    {
        $path = $this->getRealPath();
        return !empty($path) && @file_exists($path);
    }

    /**
     * Check if the object path (not the file itself but its container) exists in the server filesystem
     *
     * @return bool `true` if it exists, `false` otherwise
     */
    public function pathExists()
    {
        $path = $this->getPath();
        return !empty($path) && @file_exists($path) && @is_dir($path);
    }

    /**
     * Check if the object's root directory exists in the server filesystem
     *
     * @return bool `true` if it exists, `false` otherwise
     */
    public function rootDirExists()
    {
        $path = $this->getRootDir();
        return !empty($path) && @file_exists($path) && @is_dir($path);
    }

    /**
     * Gets the directory name transformed to be displayed as a title
     *
     * @return string The directory name transformed
     */
    public function getHumanReadableFilename()
    {
        $file_name = $this->getBasename();
        return WebFilesystem::getHumanReadableName($file_name);
    }

    /**
     * Get the PHP standard `stat()` function result
     *
     * The resulting table is returned with string indexes only
     * and few values transformed added depending on object's flags.
     *
     * @return array The result of the `stat()` function on the file, with string indexes only
     */
    public function getStat()
    {
        if ($this->exists()) {
            $flags = $this->getFlags();
            $stats = @stat($this->getRealPath());
            if ($stats) {
                foreach($stats as $i=>$val) {
                    if (!is_string($i)) {
                        unset($stats[$i]);
                    } else {
                        if ((self::STAT_DATETIME_FIELD & $this->flags) && in_array($i, array('atime', 'mtime', 'ctime'))) {
                            $stats[$i.'DateTime'] = WebFilesystem::getDateTimeFromTimestamp($val);
                        } elseif ((self::STAT_SIZE_FIELD & $this->flags) && $i==='size') {
                            $stats[$i.'Transformed'] = WebFilesystem::getTransformedFilesize($val);
                        }
                    }
                }
            }
            return $stats;
        }
        return null;
    }

    /**
     * Get the `MIME` type of the object
     *
     * @return string The mime type string
     */
    public function getMimeType()
    {
        if ($this->exists()) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE | FILEINFO_PRESERVE_ATIME);
            $mime = $finfo->file( $this->getRealPath() );
            return $mime;
        }
        return null;
    }

    /**
     * Get the `MIME` charset of the object
     *
     * @return string The mime charset string
     */
    public function getCharset()
    {
        if ($this->exists()) {
            $finfo = new \finfo(FILEINFO_MIME_ENCODING | FILEINFO_PRESERVE_ATIME);
            $mime = $finfo->file( $this->getRealPath() );
            return $mime;
        }
        return null;
    }

    /**
     * Get the full `MIME` information of the object
     *
     * @return string The full mime string like 'type ; charset'
     */
    public function getMime()
    {
        if ($this->exists()) {
            $finfo = new \finfo(FILEINFO_MIME | FILEINFO_PRESERVE_ATIME);
            $mime = $finfo->file( $this->getRealPath() );
            return $mime;
        }
        return null;
    }

}

// Endfile