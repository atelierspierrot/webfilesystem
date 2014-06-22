<?php
/**
 * PHP WebFilesystem package of Les Ateliers Pierrot
 * Copyleft (c) 2013-2014 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <http://github.com/atelierspierrot/webfilesystem>
 */

namespace WebFilesystem;

use WebFilesystem\WebFilesystem;
use WebFilesystem\WebFilesystemIterator;

/**
 */
class WebRecursiveDirectoryIterator extends WebFilesystemIterator implements 
    \SeekableIterator,
    \Traversable,
    \Iterator,
    \RecursiveIterator,
    \Countable
{

    /**
     * A callback executed to validate each file entry (must return a boolean)
     */
    protected $file_validation_callback;

    /**
     * A callback executed to validate each directory entry (must return a boolean)
     */
    protected $directory_validation_callback;

    /**
     * A class name to return for each `current()` method's file
     *
     * The default class used will be `WebFilesystem\WebFileInfo`.
     */
    protected $file_class = 'WebFilesystem\WebFileInfo';

    /**
     * A counter flag for recursive count
     * @internal
     */
    private $count=0;

    /**
     * @param string $path The path of the new filesystem object
     * @param int $flags The object options'flags value
     * @param callback $file_validation_callback A callback to validate each file item
     * @param callback $directory_validation_callback A callback to validate each directory item
     */
    public function __construct($path, $flags = 16432, $file_validation_callback = null, $directory_validation_callback = null)
    {
        parent::__construct( $path, $flags );
        $this->setFileValidationCallback( $file_validation_callback );
        $this->setDirectoryValidationCallback( $directory_validation_callback );
    }

    /**
     * Set a class name to build each item
     *
     * @param string $class_name The class name to use ; the class must exist and be callable
     * @return self The object itself is returned for method chaining
     */
    public function setFileClass($class_name = null)
    {
        $this->file_class = $class_name;
        return $this;
    }

    /**
     * Get the class name to build each item
     *
     * @return string The class name to use ; the class must exist and be callable
     */
    public function getFileClass()
    {
        return $this->file_class;
    }

    /**
     * Set a valid callback to validate each file item
     *
     * @param callback $file_validation_callback A callback to validate each file item
     * @return self The object itself is returned for method chaining
     */
    public function setFileValidationCallback($callback)
    {
        $this->file_validation_callback = $callback;
        return $this;
    }

    /**
     * Set a valid callback to validate each file item
     *
     * @return callback the callback to validate each file item
     */
    public function getFileValidationCallback()
    {
        return $this->file_validation_callback;
    }

    /**
     * Set a valid callback to validate each directory item
     *
     * @param callback $directory_validation_callback A callback to validate each directory item
     * @return self The object itself is returned for method chaining
     */
    public function setDirectoryValidationCallback($callback)
    {
        $this->directory_validation_callback = $callback;
        return $this;
    }

    /**
     * Set a valid callback to validate each directory item
     *
     * @return callback The callback to validate each directory item
     */
    public function getDirectoryValidationCallback()
    {
        return $this->directory_validation_callback;
    }

    /**
     * Implementing the `getChildren()` method to return this class for directories items
     *
     * @return class A new object with the same options as `self`
     */
    public function getChildren()
    {
        $_cls = __CLASS__;
        return new $_cls(
            $this->getRealPath(),
            $this->getFlags(),
            $this->getFileValidationCallback(),
            $this->getDirectoryValidationCallback()
        );
    }

    /**
     * Implementing the `getSubPath()` method
     *
     * @return null|string The path of the current sub-directory
     */
    public function getSubPath()
    {
        if ($this->hasChildren()) {
            $path = $this->getFilename();
            $name = $this->getBasename();
            return str_replace($name, '', $path);
        }
        return null;
    }

    /**
     * Implementing the `getSubPathname()` method
     *
     * @return null|string The pathname of the current sub-directory
     */
    public function getSubPathname()
    {
        if ($this->hasChildren()) {
            return $this->getBasename();
        }
        return null;
    }

    /**
     * Implementing the `hasChildren()` method
     *
     * @return bool `true` if the current item seems to be a directory, `false` otherwise
     */
    public function hasChildren($allow_links=false)
    {
        return is_dir($this->getRealPath());
    }

    /**
     * Implementing the `seek()` method of the `Seekable` interface
     *
     * @throws \OutOfBoundsException if the provided position doesn't exist
     * @return void
     */
    public function seek($position)
    {
        $this->rewind();
        for($i=0; $i<$position; $i++) {
            $this->next();
        }
        if (!$this->valid()) {
            throw new \OutOfBoundsException(
                sprintf('Invalid seek position "%s"!', $position)
            );
        }
    }

    /**
     * Overwriting the default `current()` method to use the file class option
     *
     * @throws \LogicException if the file class defined can't be found
     * @throws \LogicException if the file class doesn't extend `WebFilesystem\WebFileInfo`
     * @return mixed The result of the parent `current()` method if the item is a directory or no
     *              specific class is set ; an instance of the file class option otherwise
     */
    public function current()
    {
        $parent = parent::current();
        if (get_class($parent)===$this->getFileClass() || $this->hasChildren()) {
            return $parent;
        }
        if (!class_exists($this->getFileClass())) {
            throw new \LogicException(
                sprintf('Class named "%s" not found!', $this->getFileClass())
            );
        }
        if ($this->getFileClass()!=='WebFilesystem\WebFileInfo' && !is_subclass_of($this->getFileClass(), 'WebFilesystem\WebFileInfo')) {
            throw new \LogicException(
                sprintf('Class "%s" must extend "WebFilesystem\WebFileInfo"!', $this->getFileClass())
            );
        }
        $_cls = $this->getFileClass();
        $realpath = $this->getRealPath();
        $path = $this->getPathname();
        return new $_cls( $path, str_replace($path, '', $realpath) );
    }

    /**
     * Overwriting the default `rewind()` method to skip files beginning with a dot if so
     *
     * If the flag `SKIP_DOTTED` is active, this will skip files beginning with a dot
     *
     * @return void
     */
    public function rewind()
    {
        parent::rewind();
        if ($this->valid()) {
            $this->_validateItem();
        }
    }

    /**
     * Overwriting the default `next()` method to skip files beginning with a dot if so
     *
     * If the flag `SKIP_DOTTED` is active, this will skip files beginning with a dot
     *
     * @return void
     */
    public function next()
    {
        parent::next();
        if ($this->valid()) {
            $this->_validateItem();
        }
    }

    /**
     * Implementation of the `count()` method on each recursion items and sub-items
     *
     * @return int The count of the object valid items and sub-items recursively
     */
    public function recursiveCount()
    {
        $count=0;
        foreach ($this as $val) {
            $count++;
            if ($this->hasChildren()) {
                $count += $this->_countChildren();
            }
        }
        return $count;
    }

    /**
     * Count children of a sub-directory
     *
     * @internal
     * @return int The number of `current()` entry valid sub-items recursively
     */
    protected function _countChildren()
    {
        $_this = $this->getChildren();
        if ($_this) {
            return $_this->recursiveCount();
        }
        return 0;
    }
    
    /**
     * Validate `current()` with object's callbacks if so
     *
     * @internal
     */
    protected function _validateItem()
    {
        if ($this->valid()) {
            if ($this->hasChildren() && $this->getDirectoryValidationCallback()) {
                $this->_validate( $this->getDirectoryValidationCallback() );
            }
            elseif (is_file($this->getRealPath()) && $this->getFileValidationCallback()) {
                $this->_validate( $this->getFileValidationCallback() );
            }
        }
    }
    
    /**
     * Validate `current()` with a specific callback if so
     *
     * @param callback $callback One of the object's callback to execute on current item
     * @throws \LogicException If the callback is not a function or is not callable
     * @throws \BadFunctionCallException If running the callback throws an exception
     * @internal
     */
    protected function _validate($callback)
    {
        if (empty($callback) || !$this->valid()) {
            return;
        }

/*
        if (!is_null($callback) && (!function_exists($callback) && !is_callable($callback))) {
            throw new \LogicException(
                sprintf('Function named "%s" used as callback does not exist or is not callable!', $callback)
            );
        }

        if (!is_null($callback) && !is_dir($this->getRealPath())) {
            try {
                $result = call_user_func($callback, $this->getRealPath());
                if (false===$result) {
                    $this->next();
                }
            } catch(Exception $e) {
                throw new \BadFunctionCallException(
                    sprintf('Function named "%s" used as callback sent an exception with argument "%s"!', $callback, $entry),
                    0, $e
                );
            }
        }
*/
        if (!is_null($callback) && (@function_exists($callback) || @is_callable($callback))) {
            try {
                $result = call_user_func($callback, $this->getRealPath());
                if (false===$result) {
                    $this->next();
                }
            } catch(\Exception $e) {
                throw new \BadFunctionCallException(
                    sprintf('Function named "%s" used as callback sent an exception with argument "%s"!', $callback, $entry),
                    0, $e
                );
            }
        } else {
            throw new \LogicException(
                sprintf('Function named "%s" used as callback does not exist or is not callable!', $callback)
            );
        }
    }

}

// Endfile