<?php
/*
 * This file is part of PHP-framework GI.
 *
 * PHP-framework GI is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP-framework GI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP-framework GI. If not, see <https://www.gnu.org/licenses/>.
 */
namespace GI\FileSystem\Factory;

use GI\Pattern\Factory\FactoryInterface as BaseInterface;

use GI\FileSystem\FSO\FSOInterface;

use GI\FileSystem\FSO\Meta\MetaInterface;
use GI\FileSystem\FSO\FSODir\FSODirInterface;
use GI\FileSystem\FSO\FSODir\ClassDirInterface;
use GI\FileSystem\FSO\FSODir\Collection\ArrayList\ArrayListInterface as FSODirArrayListInterface;
use GI\FileSystem\FSO\FSODir\Collection\HashSet\HashSetInterface as FSODirHashSetInterface;
use GI\FileSystem\FSO\FSOFile\FSOFileInterface;
use GI\FileSystem\FSO\FSOFile\Collection\ArrayList\ArrayListInterface as FSOFileArrayListInterface;
use GI\FileSystem\FSO\FSOFile\Collection\HashSet\HashSetInterface as FSOFileHashSetInterface;
use GI\FileSystem\FSO\Symlink\SymlinkInterface;
use GI\FileSystem\FSO\Symlink\URLHolder\URLHolderInterface;
use GI\FileSystem\FSO\Symlink\Collection\ArrayList\ArrayListInterface as SymlinkArrayListInterface;
use GI\FileSystem\FSO\Symlink\Collection\HashSet\HashSetInterface as SymlinkHashSetInterface;
use GI\FileSystem\FSO\Collection\ArrayList\ArrayListInterface as FSOArrayListInterface;
use GI\FileSystem\FSO\Collection\HashSet\HashSetInterface as FSOHashSetInterface;

use GI\FileSystem\Stream\Reader\ReaderInterface as StreamReaderInterface;
use GI\FileSystem\Stream\Writer\WriterInterface as StreamWriterInterface;

use GI\FileSystem\CSV\Reader\ReaderInterface as CSVReaderInterface;
use GI\FileSystem\CSV\Writer\WriterInterface as CSVWriterInterface;

/**
 * Interface FactoryInterface
 * @package GI\FileSystem\Factory
 *
 * @method MetaInterface createMeta(FSOInterface $fso)
 * @method FSODirInterface createDir(string $path)
 * @method ClassDirInterface createClassDir(string $class)
 * @method FSODirArrayListInterface createDirArrayList(array $items = [])
 * @method FSODirHashSetInterface createDirHashSet(array $items = [])
 * @method FSOFileInterface createFile(string $path)
 * @method FSOFileArrayListInterface createFileArrayList(array $items = [])
 * @method FSOFileHashSetInterface createFileHashSet(array $items = [])
 * @method SymlinkInterface createSymlink(string $path, FSOInterface $target = null)
 * @method SymlinkArrayListInterface createSymlinkArrayList(array $items = [])
 * @method SymlinkHashSetInterface createSymlinkHashSet(array $items = [])
 * @method URLHolderInterface createURLHolder(FSOInterface $target, string $path, string $webRoot = '', string $rootURL = '')
 * @method FSOArrayListInterface createFSOArrayList(array $items = [])
 * @method FSOHashSetInterface createFSOHashSet(array $items = [])
 *
 * @method StreamReaderInterface createStreamReader($handle)
 * @method StreamWriterInterface createStreamWriter($handle)
 *
 * @method CSVReaderInterface createCSVReader(FSOFileInterface $file)
 * @method CSVWriterInterface createCSVWriter(FSOFileInterface $file)
*/
interface FactoryInterface extends BaseInterface
{

}