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
use \Library\Helper\Url as UrlHelper;
use \Library\Helper\Regex as RegexHelper;
use \Patterns\Abstracts\AbstractStaticCreator;

/**
 */
class Finder
    extends AbstractStaticCreator
    implements \Iterator
{

    protected $_is_inited = false;
    protected $iterator;

    protected $iterator_flags;
    protected $flags;
    protected $_recursion_depth = 0;

    protected $depth = null;
    protected $root_dir;
    protected $directories = array();
    protected $excluded_directories = array();
    protected $name_masks = array();
    protected $excluded_name_masks = array();
    protected $extension_masks = array();
    protected $excluded_extension_masks = array();

    const FIND_FILES    = 0x000001;
    const FIND_DIRS     = 0x000010;
    const FIND_LINKS    = 0x000100;

// ------------------------
// Init
// ------------------------

    public function init($flags = 16432)
    {
        $this
            ->setIteratorFlags($flags)
            ->setInited(false)
            ->reset();
    }

    public function reset()
    {
        $this->iterator = new \ArrayIterator;
        return $this;
    }

// ------------------------
// Setters / Getters
// ------------------------

    /**
     * @param bool $inited
     */
    public function setInited($inited)
    {
        $this->_is_inited = $inited;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInited()
    {
        return (bool) true===$this->_is_inited;
    }

    /**
     * @param string $path
     * @throws `InvalidArgumentException` if `$path` doesn't exist
     */
    public function setRootDir($path)
    {
        if (@file_exists($path)) {
            $this->root_dir = $path;
        } else {
            throw new \InvalidArgumentException(
                sprintf('Path "%s" to define root directory not found!', $path)
            );
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->root_dir;
    }

    /**
     * @param string $path
     * @throws `InvalidArgumentException` if `$path` doesn't exist
     */
    public function addDirectory($path)
    {
        if (file_exists($path)) {
            if (!in_array($path, $this->directories)) {
                $this->directories[] = $path;
                $this->setInited(false);
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf('Path "%s" not found!', $path)
            );
        }
        return $this;
    }

    /**
     * @param array $paths
     * @throws `InvalidArgumentException` if one of the `$paths` doesn't exist
     */
    public function setDirectories(array $paths)
    {
        foreach ($paths as $_path) {
            $this->addDirectory($_path);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * @param string $path
     * @throws `InvalidArgumentException` if `$path` doesn't exist
     */
    public function addExcludedDirectory($path)
    {
        if (!in_array($path, $this->excluded_directories)) {
            $this->excluded_directories[] = $path;
            $this->setInited(false);
        }
        return $this;
    }

    /**
     * @param array $paths
     * @throws `InvalidArgumentException` if one of the `$paths` doesn't exist
     */
    public function setExcludedDirectories(array $paths)
    {
        foreach ($paths as $_path) {
            $this->addExcludedDirectory($_path);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getExcludedDirectories()
    {
        return $this->excluded_directories;
    }

    /**
     * @param string $mask
     */
    public function addNameMask($mask)
    {
        if (!in_array($mask, $this->name_masks)) {
            $this->name_masks[] = $mask;
        }
        return $this;
    }

    /**
     * @param array $masks
     */
    public function setNameMasks(array $masks)
    {
        foreach ($masks as $_mask) {
            $this->addNameMask($_mask);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getNameMasks()
    {
        return $this->name_masks;
    }

    /**
     * @param string $mask
     */
    public function addExcludedNameMask($mask)
    {
        if (!in_array($mask, $this->excluded_name_masks)) {
            $this->excluded_name_masks[] = $mask;
        }
        return $this;
    }

    /**
     * @param array $masks
     */
    public function setExcludedNameMasks(array $masks)
    {
        foreach ($masks as $_mask) {
            $this->addExcludedNameMask($_mask);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getExcludedNameMasks()
    {
        return $this->excluded_name_masks;
    }

    /**
     * @param string $mask
     */
    public function addExtensionMask($mask)
    {
        if (!in_array($mask, $this->extension_masks)) {
            $this->extension_masks[] = $mask;
        }
        return $this;
    }

    /**
     * @param array $masks
     */
    public function setExtensionMasks(array $masks)
    {
        foreach ($masks as $_mask) {
            $this->addExtensionMask($_mask);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getExtensionMasks()
    {
        return $this->extension_masks;
    }

    /**
     * @param string $mask
     */
    public function addExcludedExtensionMask($mask)
    {
        if (!in_array($mask, $this->excluded_extension_masks)) {
            $this->excluded_extension_masks[] = $mask;
        }
        return $this;
    }

    /**
     * @param array $masks
     */
    public function setExcludedExtensionMasks(array $masks)
    {
        foreach ($masks as $_mask) {
            $this->addExcludedExtensionMask($_mask);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getExcludedExtensionMasks()
    {
        return $this->excluded_extension_masks;
    }

    /**
     * @param int $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $flags A set of `WebFilesystemIterator` flags
     */
    public function setIteratorFlags($flags)
    {
        $this->iterator_flags = $flags;
        $this->setInited(false);
        return $this;
    }

    /**
     * @return int A set of `WebFilesystemIterator` flags
     */
    public function getIteratorFlags()
    {
        return $this->iterator_flags;
    }

    /**
     * @param int $flags A set of `Finder` flags
     */
    public function setFlag($flag)
    {
        $this->flags = $this->flags | $flag;
        $this->setInited(false);
        return $this;
    }

    /**
     * @return int A set of `Finder` flags
     */
    public function getFlag()
    {
        return $this->flags;
    }

// ------------------------
// Aliases
// ------------------------

    public function files()
    {
        $this->setFlag(self::FIND_FILES);
        return $this;
    }

    public function dirs()
    {
        $this->setFlag(self::FIND_DIRS);
        return $this;
    }

    public function links()
    {
        $this->setFlag(self::FIND_LINKS);
        $this->setIteratorFlags($this->getIteratorFlags() | \FilesystemIterator::FOLLOW_SYMLINKS);
        return $this;
    }

    public function dots()
    {
        $this->setIteratorFlags($this->getIteratorFlags() & ~WebFilesystemIterator::SKIP_DOTTED);
        return $this;
    }

    public function depth($depth)
    {
        return $this->setDepth($depth);
    }

    public function name($mask)
    {
        return $this->addNameMask($mask);
    }

    public function notName($mask)
    {
        return $this->addExcludedNameMask($mask);
    }

    public function extension($mask)
    {
        return $this->addExtensionMask($mask);
    }

    public function notExtension($mask)
    {
        return $this->addExcludedExtensionMask($mask);
    }

    public function in($path)
    {
        return $this->addDirectory($path);
    }

    public function notIn($path)
    {
        return $this->addExcludedDirectory($path);
    }

    public function root($path)
    {
        return $this->setRootDir($path);
    }

    public function images()
    {
        foreach (WebFilesystem::$COMMON_IMG_EXTS as $mask) {
            $this->addExtensionMask($mask);
        }
        return $this;
    }

    public function videos()
    {
        foreach (WebFilesystem::$COMMON_VIDEOS_EXTS as $mask) {
            $this->addExtensionMask($mask);
        }
        return $this;
    }

// ------------------------
// Checkers
// ------------------------

    public function is($extension)
    {
        $this->getIterator();
        if (!is_array($extension)) {
            $extension = array( $extension );
        }
        $ok = false;
        foreach ($extension as $_ext) {
            if (strtolower($this->iterator->current()->getExtension())==strtolower($_ext))
                $ok = true;
        }
        return ($this->iterator->current()->isFile() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()) &&
            $ok);
    }

    public function isFile()
    {
        $this->getIterator();
        return ($this->iterator->current()->isFile() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()));
    }

    public function isDir()
    {
        $this->getIterator();
        return ($this->iterator->current()->isDir() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()));
    }

    public function isLink()
    {
        $this->getIterator();
        return ($this->iterator->current()->isLink() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()));
    }

    public function isImage()
    {
        $this->getIterator();
        return ($this->iterator->current()->isFile() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()) &&
            WebFilesystem::isCommonImage($this->iterator->current()->getRealPath()));
    }

    public function isVideo()
    {
        $this->getIterator();
        return ($this->iterator->current()->isFile() && 
            WebFilesystem::isCommonFile($this->iterator->current()->getRealPath()) &&
            WebFilesystem::isCommonVideo($this->iterator->current()->getRealPath()));
    }

    public function isDotFile()
    {
        $this->getIterator();
        return ($this->iterator->current()->isFile() && 
            WebFilesystem::isDotFile($this->iterator->current()->getRealPath()));
    }

// ------------------------
// Iterator
// ------------------------

    /**
     * @return \Iterator
     */
    public function getIterator()
    {
        $this->_find();
        return $this->iterator;
    }
            
    public function current()
    {
        $this->getIterator();
        return $this->iterator->current();
    }
    
    public function key()
    {
        $this->getIterator();
        return $this->iterator->key();
    }
    
    public function next()
    {
        $this->getIterator();
        return $this->iterator->next();
    }
    
    public function rewind()
    {
        $this->getIterator();
        return $this->iterator->rewind();
    }
    
    public function valid()
    {
        $this->getIterator();
        return $this->iterator->valid();
    }

// ------------------------
// Process
// ------------------------

    protected function _find()
    {
        if ($this->isInited()) return;
        $this->reset();
        foreach ($this->directories as $dir) {
            $this->_findByDirectory(
                UrlHelper::resolvePath($dir)
            );
        }
        $this->setInited(true);
    }
            
    protected function _findByDirectory($dir_path)
    {
        $contents = new WebRecursiveDirectoryIterator($dir_path, $this->iterator_flags);
        foreach ($contents as $file) {
            if ($file->isFile()) {
                $this->_matchFile($file);
            } elseif ($file->isDir()) {
                $this->_recursion_depth++;
                $this->_matchDir($file);
                $this->_recursion_depth--;
            }
        }
    }

    protected function _matchFile(WebFileInfo $file)
    {
        if ($this->flags & self::FIND_FILES) {
            if (!$this->_matchFilename($file->getBasename()) || !$this->_matchExtension($file->getExtension())) {
                return;
            }
            if ($file->isLink() && ($this->flags & self::FIND_LINKS)) {
                $this->iterator->append($file);
            } else {
                $this->iterator->append($file);
            }
        }
    }
            
    protected function _matchFilename($file_name)
    {
        if (!empty($this->name_masks) || !empty($this->excluded_name_masks)) {
            if (!empty($this->excluded_name_masks)) {
                foreach ($this->excluded_name_masks as $mask) {
                    if (1===preg_match(RegexHelper::getPattern($mask), $file_name)) {
                        return false;
                    }
                }
            }
            if (!empty($this->name_masks)) {
                foreach ($this->name_masks as $mask) {
                    if (1===preg_match(RegexHelper::getPattern($mask), $file_name)) {
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }

    protected function _matchExtension($file_extension)
    {
        if (!empty($this->extension_masks) || !empty($this->excluded_extension_masks)) {
            if (!empty($this->excluded_extension_masks)) {
                foreach ($this->excluded_extension_masks as $mask) {
                    if (1===preg_match(RegexHelper::getPattern($mask), $file_extension)) {
                        return false;
                    }
                }
            }
            if (!empty($this->extension_masks)) {
                foreach ($this->extension_masks as $mask) {
                    if (1===preg_match(RegexHelper::getPattern($mask), $file_extension)) {
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }

    protected function _matchDir(WebFileInfo $file)
    {
        if (is_null($this->depth) || $this->_recursion_depth<=$this->depth) {
            if (!empty($this->excluded_directories)) {
                foreach ($this->excluded_directories as $dirname) {
                    if ($file->getBasename()==$dirname) {
                        return false;
                    }
                }
            }
            if ($this->flags & self::FIND_DIRS) {
                $this->iterator->append($file);
            }
            $this->_findByDirectory($file->getRealPath());
        }
    }
            
}

// Endfile