<?php
/**
 * PHP WebFilesystem package of Les Ateliers Pierrot
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webfilesystem>
 */

namespace WebFilesystem;

/**
 * Commons static functions for the whole package
 */
class WebFilesystem
{

    /**
     * List of characters replaced by a space in a file name to build a human readable string
     */
    public static $REPLACEMENT_FILENAMES_CHARS  = array('.', '-', '_', '/');

    /**
     * List of units to build the size field, ordered by 1024 operator on original size
     */
    public static $FILESIZE_ORDERED_UNITS       = array('o','Ko','Mo','Go','To');

    /**
     * List of common image extensions
     */
    public static $COMMON_IMG_EXTS              = array( 'jpg', 'jpeg', 'tif', 'tiff', 'png', 'giff', 'gif' );
    
    /**
     * List of common videos extensions
     */
    public static $COMMON_VIDEOS_EXTS           = array( 'mp4', 'flv', 'f4v', 'mov' );
    
    /**
     * List of common ignored files when scanning a directory content
     */
    public static $IGNORED_FILES                = array( '.', '..', '.DS_Store', 'Thumbs.db', 'ehthumbs.db', 'Icon', 'Desktop.ini', '.Trashes', '.Spotlight-V100' );
    
    /**
     * List of common VCS files
     */
    private static $VCS_FILES                   = array('.svn', 'CVS', '.git', '.hg');

    /**
     * List of common file_names to ignore when scanning a directory content, based on PCRE masks
     */
    public static $IGNORED_FILES_MASKS          = array( '#^\._(.*)#i', '#(.*)~$#i' );

    /**
     * Returns a directory name with the trailing slash if needed
     *
     * This function always returns `my_dir/`, working from both `my_dir` or `my_dir/`.
     * @param string $dir_name The dir_name to work on
     * @return string The dir_name always with a trailing slalsh
     */
    public static function slashDirname($dir_name)
    {
        return rtrim($dir_name, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }

    /**
     * Render a human readable string from a file name
     *
     * The original file name is rebuilt striping the extension
     * and a set of commonly used separator characters in file or directories names.
     * @param string $file_name The file_name to work on
     * @return string The resulting human readable file name
     */
    public static function getHumanReadableName($file_name)
    {
        $ext = self::getExtensionName($file_name);
        if (!empty($ext)) {
            $file_name = str_replace('.'.$ext, '', $file_name);
        }
        return ucfirst( str_replace(self::$REPLACEMENT_FILENAMES_CHARS, ' ', $file_name) );
    }

    /**
     * Returns the extension of a file name
     *
     * It basically returns everything after last dot. No validation is done.
     * @param string $file_name The file_name to work on
     * @return null|string The extension if found, `null` otherwise
     */
    public static function getExtensionName($file_name)
    {
        return strpos($file_name, '.') ? @end(@explode('.', $file_name)) : null;
    }

    /**
     * Returns a formatted file size in bytes or derived unit
     *
     * This will return the size received transforming it to be readable, with the appropriate
     * unit chosen in `WebFilesystem::$FILESIZE_ORDERED_UNITS`.
     * @param float $size Refer to the size (in standard format given by the `stat()` function)
     * @param int $round The number of decimal places (default is 3)
     * @param string $dec_delimiter The decimal separator (default is a comma)
     */
    public static function getTransformedFilesize($size = 0, $round = 3, $dec_delimiter = ',')
    {
        $count=0;
        while($size >= 1024 && $count < (count(self::$FILESIZE_ORDERED_UNITS)-1)) {
            $count++;
            $size /= 1024;
        }
        if ($round>=0) {
            $arr = pow(10, $round);
            $number = round($size * $arr) / $arr;
        } else {
            $number = $size;
        }
        return str_replace('.',$dec_delimiter,$number).' '.self::$FILESIZE_ORDERED_UNITS[$count];
    }

    /**
     * Returns a `DateTime` object from a timestamp
     *
     * @param int $stamp The timestamp date field value
     * @return object A `DateTime` standard object based on the timestamp
     */
    public static function getDateTimeFromTimestamp($stamp)
    {
        $date = new \DateTime;
        $date->setTimestamp($stamp);
        return $date;
    }

    /**
     * Tests if a file name seems to be a valid one (also works for directories)
     *
     * This will test if a file name seems valid by skipping the `self::$IGNORED_FILES` file names
     * and testing it with each `self::$IGNORED_FILES_MASKS` mask.
     * @param string $file_name The file name to test
     * @return bool `true` if the file name seems to be valid, `false` otherwise
     */
    public static function isCommonFile($file_name)
    {
        if (in_array($file_name, self::$IGNORED_FILES)) {
            return false;
        }
        foreach(self::$IGNORED_FILES_MASKS as $_mask) {
            if (preg_match($_mask, $file_name)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Tests if a file name begins with a dot (also works for directories)
     *
     * This will test if a file name seems valid by skipping the `self::$IGNORED_FILES` file names
     * and testing it with each `self::$IGNORED_FILES_MASKS` mask.
     * @param string $file_name The file name to test
     * @return bool `true` if the file name seems to be valid, `false` otherwise
     */
    public static function isDotFile($file_name)
    {
        $ok = self::isCommonFile($file_name);
        if ($ok) {
            $name = basename($file_name);
            return ($name{0}==='.');
        }
        return $ok;
    }
    
    /**
     * Tests if a file name seems to have a common image's extension
     *
     * Directories (if known) or file names beginning with a dot are skipped.
     * @param string $file_name The file name to test
     * @return bool `true` if the file_name seems to be an image, `false` otherwise
     */
    public static function isCommonImage($file_name)
    {
        if (!self::isCommonFile($file_name) || $file_name{0}==='.' || @is_dir($file_name)) {
            return false;
        }
        $ext = self::getExtensionName($file_name);
        return ($ext ? in_array(strtolower($ext), self::$COMMON_IMG_EXTS) : false);
    }

    /**
     * Tests if a file name seems to have a common video's extension
     *
     * Directories (if known) or file names beginning with a dot are skipped.
     * @param string $file_name The file name to test
     * @return bool `true` if the file_name seems to be a video, `false` otherwise
     */
    public static function isCommonVideo($file_name)
    {
        if (!self::isCommonFile($file_name) || $file_name{0}==='.' || @is_dir($file_name)) {
            return false;
        }
        $ext = self::getExtensionName($file_name);
        return ($ext ? in_array(strtolower($ext), self::$COMMON_VIDEOS_EXTS) : false);
    }

}

// Endfile
