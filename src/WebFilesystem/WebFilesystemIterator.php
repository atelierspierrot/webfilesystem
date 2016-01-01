<?php
/**
 * This file is part of the WebFilesystem package.
 *
 * Copyright (c) 2013-2016 Pierre Cassat <me@e-piwi.fr> and contributors
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *      http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * The source code of this package is available online at 
 * <http://github.com/atelierspierrot/webfilesystem>.
 */

namespace WebFilesystem;

use WebFilesystem\WebFileInfo;
use Library\Helper\Directory as DirectoryHelper;

/**
 * Special web's version of the PHP >=5.3 standard class `FilesystemIterator` <http://www.php.net/manual/en/class.splfileinfo.php>
 *
 * @author  piwi <me@e-piwi.fr>
 */
class WebFilesystemIterator extends \FilesystemIterator implements
    \SeekableIterator,
    \Traversable,
    \Iterator,
    \Countable
{

    /**
     * The original path passed to constructor
     */
    protected $original_path;

    /**
     * New flag to skip files with a name beginning with a dot
     *
     * It is part of the default object's flags
     */
    const SKIP_DOTTED               = 0x00004000;

    /**
     * New flag to make `current()` returns a `WebFileInfo` object
     *
     * It is part of the default object's flags
     */
    const CURRENT_AS_WEBFILEINFO    = 0x00000030;

    /**
     * Overwriting the constructor to use the new `setFlags()` method and set a new default flags value
     *
     * The new default flags are : WebFilesystemIterator::KEY_AS_PATHNAME | WebFilesystemIterator::CURRENT_AS_WEBFILEINFO | WebFilesystemIterator::SKIP_DOTTED
     *
     * @param string $path The path of the new filesystem object
     * @param int $flags The object options'flags value
     */
    public function __construct($path, $flags = 16432)
    {
        $this->original_path = $path;
        parent::__construct($path, $flags);
        $this->setFlags($flags);
        if ($this->valid() && ($this->getFlags() & WebFilesystemIterator::SKIP_DOTTED)) {
            $this->_skipDottedIfSo();
        }
    }

    /**
     * Overwriting the default `setFlags()` method to accept new flags
     *
     * @param int $flags A set of object options'flags
     * @return self The object itself is returned for method chaining
     */
    public function setFlags($flags = null)
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * Overwriting the default `getFlags()` method to accept new flags
     *
     * @return int The current options'flags value for the object
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Overwriting the default `current()` method to return a `WebFileInfo` object if so
     *
     * If the flag `CURRENT_AS_WEBFILEINFO` is active, this will return a `WebFileInfo` object.
     *
     * @return mixed The value of the current iteration, as a `WebFileInfo` object if requested or as the default result of the parent's method
     */
    public function current()
    {
        if ($this->getFlags() & WebFilesystemIterator::CURRENT_AS_WEBFILEINFO) {
            /*
            if ($this->isLink()) {
                return new WebFileInfo($this->getPathname());
            } else {
                $realpath = $this->getRealPath();
                $path = $this->getPathname();
                return new WebFileInfo($path, str_replace($path, '', $realpath));
            }
*/
            return new WebFileInfo(
                DirectoryHelper::slashDirname($this->original_path).$this->getFilename()
            );
        }
        return parent::current();
    }

    /**
     * Overwriting the default `rewind()` method to skip files beginning with a dot if so
     *
     * It the flag `SKIP_DOTTED` is active, this will skip files beginning with a dot.
     *
     * @return void
     */
    public function rewind()
    {
        parent::rewind();
        if ($this->valid() && ($this->getFlags() & WebFilesystemIterator::SKIP_DOTTED)) {
            $this->_skipDottedIfSo();
        }
    }

    /**
     * Overwriting the default `next()` method to skip files beginning with a dot if so
     *
     * If the flag `SKIP_DOTTED` is active, this will skip files beginning with a dot.
     *
     * @return void
    */
    public function next()
    {
        parent::next();
        if ($this->valid() && ($this->getFlags() & WebFilesystemIterator::SKIP_DOTTED)) {
            $this->_skipDottedIfSo();
        }
    }

    /**
     * Implementation of the `count()` method of the `Countable` interface
     *
     * @return int The number of valid items of the object
     */
    public function count()
    {
        $count=0;
        foreach ($this as $val) {
            $count++;
        }
        return $count;
    }

    /**
     * Make the iterator skip files beginning with a dot
     *
     * If the flag `SKIP_DOTTED` is active, this will skip files beginning with a dot and pass
     * to next item using the `next()` method if the object is still `valid()`.
     *
     * @return void
     */
    protected function _skipDottedIfSo()
    {
        $_f = $this->getBasename();
        if ($this->valid() && !empty($_f) && ($this->getFlags() & WebFilesystemIterator::SKIP_DOTTED) && $_f{0}==='.') {
            $this->next();
        }
    }
}
