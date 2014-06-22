<?php
/**
 * PHP WebFilesystem package of Les Ateliers Pierrot
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webfilesystem>
 */

namespace WebFilesystem\FileType;

use WebFilesystem\WebFilesystem;
use WebFilesystem\WebFileInfo;

use Library\Helper\Directory as DirectoryHelper;

/**
 */
class WebImage extends WebFileInfo
{

    /**
     * Thumbs directory path mask
     *
     * This value is parsed like `sprintf(val, $directory);`
     */
    public static $THUMBS_PATH = '%s/thumbs/';
    
    /**
     * List of all IPTC field names
     */
    public static $iptc_fields = array(
        '005' => 'object name',
        '007' => 'edition status',
        '010' => 'priority',
        '015' => 'category',
        '020' => 'category added',
        '022' => 'id',
        '025' => 'keywords',
        '026' => 'location',
        '030' => 'out date',
        '035' => 'out hour',
        '040' => 'specials',
        '055' => 'creation date',
        '060' => 'creation hour',
        '065' => 'software',
        '070' => 'software version',
        '075' => 'cycle',
        '080' => 'creator',
        '085' => 'creator status',
        '090' => 'city',
        '092' => 'region',
        '095' => 'state',
        '100' => 'country code',
        '101' => 'country',
        '103' => 'reference',
        '105' => 'title',
        '110' => 'credits',
        '115' => 'source',
        '116' => 'copyright',
        '118' => 'contact',
        '120' => 'legend',
        '122' => 'author',
    );

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
     * @param   string  $path The path of the file
     * @param   string  $root_dir The absolute path of the root directory
     * @param   string  $file_name The name of the file
     * @param   bool    $must_exist Does the class have to verify the file existence (default is true)
     * @throws  \Exception If the file can't be found
     */
    public function __construct($path, $root_dir = null, $file_name = null, $must_exist = true)
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
     * @return  self
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
     * @return self 
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
     * @return self 
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
     * @return array A full array of standard, EXIF and IPTC image's infos
     */
    public function getInfos()
    {
        if (!$this->exists() || !$this->isImage()) {
            return false;
        }
        $standard = self::getImageInfos();
        $iptc = self::getIptcInfos();
        $exif = self::getExifInfos();
        $result = array_merge( $standard, $iptc, $exif, array(
            'getimagesize' => $standard, 'iptc' => $iptc, 'exif' => $exif
        ));
        return $result;
    }
    
    /**
     * Scan image standrad infos
     *
     * @return array An array of retrieved image's infos
     */
    public function getImageInfos()
    {
        if (!$this->exists()) {
            return false;
        }
        $data = getimagesize( $this->getRealPath() );
        $result = array();
        if (!empty($data)) {
            if (!empty($data[0])) {
                $result['width'] = $data[0];
            }
            if (!empty($data[1])) {
                $result['height'] = $data[1];
            }
            if (!empty($data[2])) {
                $result['type'] = $data[2];
            }
            if (!empty($data[3])) {
                $result['style'] = $data[3];
            }
            if (!empty($data['channels'])) {
                $result['channels'] = $data['channels'];
                if ($data['channels']===3) {
                    $result['colors'] = 'RGB';
                }
                if ($data['channels']===4) {
                    $result['colors'] = 'CMYK';
                }
            }
            if (!empty($data['mime'])) {
                $result['mime'] = $data['mime'];
            }
            if (!empty($data['bytes'])) {
                $result['bytes'] = $data['bytes'];
            }
        }
        return $result;
    }
    
    /**
     * Scan image IPTC infos
     *
     * @return array An array of retrieved image's infos
     */
    public function getIptcInfos()
    {
        if (!$this->exists()) {
            return false;
        }
        getimagesize( $this->getRealPath(), $data );
        $_data = empty($data["APP13"]) ? array() : iptcparse($data["APP13"]);
        $iptcdata = array();
        if (!empty($data)) {
            foreach($_data as $tag => $tab) {
               $tag = substr($tag, 2);
               if (array_key_exists($tag, self::$iptc_fields)) {
                   $iptcdata[self::$iptc_fields[$tag]] = join($tab, ', ');
                }
            }
        }
        return $iptcdata;
    }
    
    /**
     * Scan image EXIF infos
     *
     * @return array An array of retrieved image's infos
     */
    public function getExifInfos()
    {
        if (!$this->exists()) {
            return false;
        }
        $exifdata = array();
        if ($data = exif_read_data($this->getRealPath(), 'EXIF', true)) {
            foreach ($data as $key => $section) {       
                foreach ($section as $name => $value) {
                    if (is_string($value)) {
                        if (!isset($exifdata[$name])) $exifdata[$name] = '';
                        $exifdata[$name] .= $value;
                    } elseif (is_array($value)) {
                        if (!isset($exifdata[$name])) $exifdata[$name] = array();
                        $exifdata[$name][] = $value;
                    }
                }
            }
            if (!empty($exifdata["GPSLongitude"]) && !empty($exifdata['GPSLongitudeRef'])) {
                $exifdata["GPSLongitudeTransformed"] = self::getGps($exifdata["GPSLongitude"][0], $exifdata['GPSLongitudeRef'][0]);
            }
            if (!empty($exifdata["GPSLatitude"]) && !empty($exifdata['GPSLatitudeRef'])) {
                $exifdata["GPSLatitudeTransformed"] = self::getGps($exifdata["GPSLatitude"][0], $exifdata['GPSLatitudeRef'][0]);
            }
            if (!empty($exifdata["DateTime"])) {
                $exifdata["DateTimeTransformed"] = self::getDateFromExif($exifdata["DateTime"]);
            }
            if (!empty($exifdata["DateTimeOriginal"])) {
                $exifdata["DateTimeOriginalTransformed"] = self::getDateFromExif($exifdata["DateTimeOriginal"]);
            }
        }
        return $exifdata;
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
     * Returns TRUE if the object is an image
     *
     * @see isCommonImage()
     */
    public function isImage()
    {
        return $this->exists() && WebFilesystem::isCommonImage($this->getFilename());
    }
    
    /**
     * Returns the transformed value of an EXIF GPS field to a standard GPS floated coordinate
     */
    public static function getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? self::gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? self::gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? self::gps2Num($exifCoord[2]) : 0;
        $flip = ($hemi == 'W' || $hemi == 'S') ? -1 : 1;
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }
    
    /**
     * Returns a transformed GPS coordinate in a numeric floated value
     *
     * @param int $coordPart The GPS coordinate to transform
     * @return float The corresponding floated value
     */
    public static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0) {
            return 0;
        }
        if (count($parts) == 1) {
            return $parts[0];
        }
        return floatval($parts[0]) / floatval($parts[1]);
    }
    
    /**
     * Returns the transformed date field form EXIF info to SQL DateTime format `AAAA-MM-DD HH:ii:ss`
     *
     * @param int $date The EXIF date field value
     * @return mixed The re-formated date in SQL format
     */
    public static function getDateFromExif($date)
    {
        $date_full  = explode(":", @current(explode(" ", $date)));
        $hour_full  = explode(":", @next(explode(" ", $date)));
        $year       = current($date_full);
        $month      = next($date_full);
        $day        = next($date_full);
        $hour       = current($hour_full);
        $minutes    = next($hour_full);
        $seconds    = next($hour_full);
        return "$year-$month-$day $hour:$minutes:$seconds";
    }
    
    /**
     * Get the `base64` encoded image content
     * 
     * @param bool $to_href Set to `true` to get a full result to use in `img` tag
     * @return string
     */
    public function getBase64Content($to_href = false)
    {
        if ($this->exists() && $this->isImage()) {
            $image_infos = $this->getImageInfos();
            $base64 = '';
            if ($to_href) {
                $type = pathinfo($this->getRealPath(), PATHINFO_EXTENSION);
                $base64 .= 'data:image/' . $type . ';base64,';
            }
            $data = file_get_contents($this->getRealPath());
            $base64 .= base64_encode($data);
            return $base64;
        }
        return '';
    }
    
    /**
     * Get the image's height in pixels
     *
     * @return null|int
     */
    public function getHeight()
    {
        $image_infos = $this->getImageInfos();
        return isset($image_infos['height']) ? $image_infos['height'] : null;
    }
    
    /**
     * Get the image's width in pixels
     *
     * @return null|int
     */
    public function getWidth()
    {
        $image_infos = $this->getImageInfos();
        return isset($image_infos['width']) ? $image_infos['width'] : null;
    }

}

// Endfile