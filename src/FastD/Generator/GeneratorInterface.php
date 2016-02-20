<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午5:01
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Property;

/**
 * Interface GeneratorInterface
 * @package FastD\Generator
 */
interface GeneratorInterface
{
    /**
     * @return string
     */
    public function getFile();

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @param array Property[] $properties
     * @return GeneratorInterface
     */
    public function setProperties(array $properties);

    /**
     * @return Property[]
     */
    public function getProperties();

    /**
     * @param array Method[] $methods
     * @return GeneratorInterface
     */
    public function setMethods(array $methods);

    /**
     * @return Method[]
     */
    public function getMethods();

    /**
     * @param bool $output
     * @return string|void
     */
    public function output($output = true);

    /**
     * @param string $file
     * @return int
     */
    public function save($file = null);

    /**
     * @return mixed
     */
    public function getParser();
}