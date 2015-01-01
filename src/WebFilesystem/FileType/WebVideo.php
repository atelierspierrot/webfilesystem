<?php
/**
 * PHP WebFilesystem package of Les Ateliers Pierrot
 * Copyleft (ↄ) 2013-2015 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webfilesystem>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace WebFilesystem\FileType;

use WebFilesystem\WebFilesystem;
use WebFilesystem\WebFileInfo;

use Library\Helper\Directory as DirectoryHelper;

/**
 */
class WebVideo extends WebFileInfo
{

    /**
     * Thumbs directory path mask
     *
     * This value is parsed like `sprintf(val, $directory);`
     */
    public static $THUMBS_PATH = '%s/thumbs/';

    /**
     * The thumb file name
     */
    protected $thumb_file_name;

    /**
     * The thumb file relative web path (without file name)
     */
    protected $thumb_path;

    /**
     * The absolute path to the thumb path directory
     */
    protected $thumb_root_dir;

    /**
     * Construct a new myDirectory object
     *
     * @param   string $path The path of the file
     * @param   string $root_dir The absolute path of the root directory
     * @param   string $file_name The name of the file
     * @param   bool $must_exist Does the class have to verify the file existence (default is true)
     * @throws  \Exception If the file can't be found
     */
    public function __construct($path, $root_dir, $file_name = null, $must_exist = true)
    {
        if (!empty($file_name)) {
            $path = DirectoryHelper::slashDirname($path).$file_name;
        }
        parent::__construct( $path, $root_dir );
        if ($must_exist && !$this->exists()) {
            throw new \Exception(
                sprintf('File "%s" (searched in "%s") not found!', $path, $root_dir)
            );
        }
        parent::setWebPath( $this->getPath() );
        $this->setThumbFilename( $this->getBasename() );
        $this->setThumbRootDir( $this->getRootDir() );
        $this->setThumbPath( sprintf(self::$THUMBS_PATH, rtrim($this->getWebPath(), '/')) );
    }

    /**
     * Sets the object thumb file name
     *
     * @param   string $file_name The file_name to set, without other path (just a file_name)
     * @return  self The object itself is returned for method chaining
     */
    public function setThumbFilename($file_name)
    {
        $this->thumb_file_name = $file_name;
        return $this;
    }

    /**
     * Get the object's thumb file name
     *
     * @return string The object thumb file name, without any directory
     */
    public function getThumbFilename()
    {
        return str_replace($this->getThumbRootDir(), '', $this->getThumbPathname());
    }

    /**
     * Get the object's thumb file name
     *
     * @return string The object thumb file name, without any directory
     */
    public function getThumbBasename()
    {
        return $this->thumb_file_name;
    }

    /**
     * Sets the object thumb root directory
     *
     * @param string $path The path to set, without the file name
     * @return self The object itself is returned for method chaining
     */
    public function setThumbRootDir($path)
    {
        $this->thumb_root_dir = $path;
        return $this;
    }

    /**
     * Get the object's thumb root directory
     *
     * @return string The object thumb web path, without the file name
     */
    public function getThumbRootDir()
    {
        return (!empty($this->thumb_root_dir) ? DirectoryHelper::slashDirname($this->thumb_root_dir) : '');
    }

    /**
     * Sets the object thumb web path
     *
     * @param string $path The web path to set, without the file name
     * @return self The object itself is returned for method chaining
     */
    public function setThumbPath($path)
    {
        $this->thumb_path = $path;
        return $this;
    }

    /**
     * Get the object's thumb web path
     *
     * @return string The object thumb web path, without the file name
     */
    public function getThumbPath()
    {
        return (!empty($this->thumb_path) ? str_replace($this->getThumbRootDir(), '', DirectoryHelper::slashDirname($this->thumb_path)) : '');
    }

    /**
     * Get the object's thumb web path with file name
     *
     * @return string The object thumb web path, with the file name
     */
    public function getThumbPathname()
    {
        return $this->getThumbPath().$this->getThumbBasename();
    }

    /**
     * Get the object's web real path (with the file_name)
     * This returns a directly HTML writable directory or file path
     *
     * @return string The object web full file path
     */
    public function getThumbRealPath()
    {
        return $this->getThumbRootDir().$this->getThumbPathname();
    }

    /**
     * Get the object's thumb web path
     *
     * @return string The object thumb web path, without the file name
     */
    public function getThumbWebPath()
    {
        return $this->getThumbPath();
    }

    /**
     * Get the object's web real path (with the file_name)
     * This returns a directly HTML writable directory or file path
     *
     * @return string The object web full file path
     */
    public function getThumbRealWebPath()
    {
        return $this->getThumbPathname();
    }

    /**
     * Scan all image infos
     *
     * @return array
     */
    public function getInfos()
    {
        if (!$this->exists() || !$this->isVideo()) {
            return false;
        }
        $standard = self::getVideoInfos();
        return $standard;
    }

    /**
     * Scan video standrad infos
     *
     * @return array An array of retrieved video's infos
     */
    public function getVideoInfos()
    {
        if (!$this->exists()) {
            return false;
        }
        $vid = new \finfo(FILEINFO_MIME_TYPE);
        $data = $vid->file( $this->getRealPath() );
        return $data;
    }

    /**
     * Check if the object exists
     *
     * @return bool `true` if it exists, `false` otherwise
     */
    public function exists()
    {
        return parent::exists() && is_file($this->getRealPath());
    }

    /**
     * Check if the thumb exists
     *
     * @return bool `true` if it exists, `false` otherwise
     */
    public function thumbExists()
    {
        $thumb = $this->getThumbRealPath();
        return !empty($thumb) && @file_exists($thumb) && @is_file($thumb);
    }

    /**
     * Returns TRUE if the object is a video file
     *
     * @see isCommonVideo()
     */
    public function isVideo()
    {
        return $this->exists() && WebFilesystem::isCommonVideo($this->getFilename());
    }

    /**
     * Returns the transformed date field form EXIF info to SQL DateTime format `AAAA-MM-DD HH:ii:ss`
     *
     * @param int $date The EXIF date field value
     * @return mixed The re-formated date in SQL format
     */
    public static function getDateFromExif($date)
    {
        $date_full  = explode(":", current(explode(" ", $date)));
        $hour_full  = explode(":", next(explode(" ", $date)));
        $year       = current($date_full);
        $month      = next($date_full);
        $day        = next($date_full);
        $hour       = current($hour_full);
        $minutes    = next($hour_full);
        $seconds    = next($hour_full);
        return "$year-$month-$day $hour:$minutes:$seconds";
    }

}

// Endfile